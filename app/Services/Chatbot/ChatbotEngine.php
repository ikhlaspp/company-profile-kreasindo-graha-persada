<?php

namespace App\Services\Chatbot;

use App\Models\ChatConversation;
use App\Models\ChatLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Orchestrates the 3-layer hybrid chatbot.
 *
 * Layers:
 * 1. FAQ database (instant, no API)
 * 2. Gemini 2.5 Flash (grounded with KGP context)
 * 3. Grok (fallback when Gemini fails or exhausts quota)
 *
 * Falls back to a friendly static message when every layer fails, and logs
 * every exchange to chat_conversations and chat_logs tables.
 */
class ChatbotEngine
{
    /**
     * @var string
     */
    private const FALLBACK_REPLY = 'Maaf, saya belum dapat menjawab pertanyaan itu sekarang. '
        .'Silakan hubungi tim kami melalui halaman Kontak (/kontak) agar dapat dibantu lebih lanjut.';

    /**
     * ChatbotEngine constructor.
     *
     * @param FaqMatcher $faqMatcher
     * @param GeminiClient $gemini
     * @param GrokClient $grok
     * @param KgpContext $context
     */
    public function __construct(
        private readonly FaqMatcher $faqMatcher,
        private readonly GeminiClient $gemini,
        private readonly GrokClient $grok,
        private readonly KgpContext $context,
    ) {}

    /**
     * Resolves the conversation, processes the message through the AI layers,
     * logs the interaction, and returns the appropriate reply.
     *
     * @param string $message
     * @param string $sessionId
     * @param string|null $ip
     * @param string|null $userAgent
     * @return array{reply: string, source: string}
     */
    public function handle(string $message, string $sessionId, ?string $ip = null, ?string $userAgent = null): array
    {
        $conversation = $this->resolveConversation($sessionId, $ip, $userAgent);

        $start = microtime(true);
        [$reply, $source, $faqId] = $this->answer($message, $this->history($conversation));
        $elapsedMs = (int) round((microtime(true) - $start) * 1000);

        ChatLog::create([
            'chat_conversation_id' => $conversation->id,
            'faq_id' => $faqId,
            'user_message' => $message,
            'bot_reply' => $reply,
            'source' => $source,
            'response_time_ms' => $elapsedMs,
        ]);

        return ['reply' => $reply, 'source' => $source];
    }

    /**
     * Runs the message through the three layers sequentially.
     *
     * @param string $message
     * @param array<int, array{user: string, bot: string}> $history
     * @return array{0: string, 1: string, 2: int|null} [reply, source, faqId]
     */
    private function answer(string $message, array $history = []): array
    {
        if ($faq = $this->faqMatcher->match($message)) {
            $faq->increment('hit_count');

            return [$faq->answer, 'faq', $faq->id];
        }

        $systemPrompt = $this->context->systemPrompt();

        try {
            return [$this->gemini->reply($message, $systemPrompt, $history), 'gemini', null];
        } catch (ChatbotException $e) {
            Log::info('Chatbot: Gemini API failed, attempting Grok fallback.', ['error' => $e->getMessage()]);
        }

        try {
            return [$this->grok->reply($message, $systemPrompt, $history), 'grok', null];
        } catch (ChatbotException $e) {
            Log::warning('Chatbot: All AI layers failed.', ['error' => $e->getMessage()]);
        }

        return [self::FALLBACK_REPLY, 'fallback', null];
    }

    /**
     * Retrieves recent exchanges in the conversation.
     *
     * Returns the oldest first, allowing AI layers to follow follow-up questions.
     * Fallback replies are skipped as they hold no informational value.
     *
     * @param ChatConversation $conversation
     * @return array<int, array{user: string, bot: string}>
     */
    private function history(ChatConversation $conversation): array
    {
        return ChatLog::query()
            ->where('chat_conversation_id', $conversation->id)
            ->where('source', '!=', 'fallback')
            ->latest('id')
            ->take(6)
            ->get(['user_message', 'bot_reply'])
            ->reverse()
            ->map(fn (ChatLog $log) => [
                'user' => Str::limit($log->user_message, 1000, ''),
                'bot' => Str::limit($log->bot_reply, 1000, ''),
            ])
            ->values()
            ->all();
    }

    /**
     * Resolves an existing conversation or creates a new one based on the session ID.
     *
     * @param string $sessionId
     * @param string|null $ip
     * @param string|null $userAgent
     * @return ChatConversation
     */
    private function resolveConversation(string $sessionId, ?string $ip, ?string $userAgent): ChatConversation
    {
        $conversation = ChatConversation::firstOrNew(['session_id' => $sessionId]);

        if (! $conversation->exists) {
            $conversation->visitor_ip = $ip;
            $conversation->user_agent = $userAgent;
            $conversation->started_at = now();
        }

        $conversation->last_activity_at = now();
        $conversation->save();

        return $conversation;
    }
}
