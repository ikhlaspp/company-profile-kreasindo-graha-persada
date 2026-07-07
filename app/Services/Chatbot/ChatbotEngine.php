<?php

namespace App\Services\Chatbot;

use App\Models\ChatConversation;
use App\Models\ChatLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Otak chatbot hybrid KGP.
 * Alur menjawab: FAQ dulu, lalu daftar provider AI sesuai urutan config,
 * dan jika semua gagal, pakai balasan fallback statis.
 */
class ChatbotEngine
{
    private const FALLBACK_REPLY = 'Maaf, saya belum dapat menjawab pertanyaan itu sekarang. '
        .'Silakan hubungi tim kami melalui halaman Kontak (/kontak) agar dapat dibantu lebih lanjut.';

    /**
     * @param array<int, AiProvider> $providers Rantai AI terurut, dijalankan setelah FAQ.
     */
    public function __construct(
        private readonly FaqMatcher $faqMatcher,
        private readonly KgpContext $context,
        private readonly array $providers,
    ) {}

    public function handle(string $message, string $sessionId, ?string $ip = null, ?string $userAgent = null): array
    {
        // Pastikan percakapan tercatat, lalu ambil jawaban sambil menghitung waktu respons.
        $conversation = $this->resolveConversation($sessionId, $ip, $userAgent);

        $start = microtime(true);
        [$reply, $source, $faqId] = $this->answer($message, $this->history($conversation));
        $elapsedMs = (int) round((microtime(true) - $start) * 1000);

        // Simpan log untuk analitik dan riwayat percakapan.
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
     * @param array<int, array{user: string, bot: string}> $history
     * @return array{0: string, 1: string, 2: int|null} [reply, source, faqId]
     */
    private function answer(string $message, array $history = []): array
    {
        // Lapisan 1 — FAQ database: paling cepat dan tanpa biaya API.
        if ($faq = $this->faqMatcher->match($message)) {
            $faq->increment('hit_count');

            return [$faq->answer, 'faq', $faq->id];
        }

        // Lapisan 2..n — coba tiap provider AI sesuai urutan; lewati yang belum dikonfigurasi.
        $systemPrompt = $this->context->systemPrompt();

        foreach ($this->providers as $provider) {
            if (! $provider->configured()) {
                continue;
            }

            try {
                return [$provider->reply($message, $systemPrompt, $history), $provider->name(), null];
            } catch (ChatbotException $e) {
                Log::info("Chatbot: provider [{$provider->name()}] gagal, lanjut ke berikutnya.", [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Lapisan terakhir — semua AI gagal atau kosong, pakai balasan aman.
        Log::warning('Chatbot: semua lapisan AI gagal atau belum dikonfigurasi.');

        return [self::FALLBACK_REPLY, 'fallback', null];
    }

    /**
     * Ambil beberapa percakapan terakhir sebagai konteks, kecuali balasan fallback.
     *
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

    private function resolveConversation(string $sessionId, ?string $ip, ?string $userAgent): ChatConversation
    {
        // Buat percakapan baru bila sesi belum ada, lalu selalu perbarui waktu aktivitas.
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