<?php

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Klien untuk semua provider ber-format OpenAI (endpoint /chat/completions).
 * Satu class ini melayani Grok, OpenAI/ChatGPT, DeepSeek, Groq, Together, dll —
 * yang membedakan hanya endpoint, model, dan API key dari config.
 */
class OpenAiCompatibleClient implements AiProvider
{
    public function __construct(
        private readonly string $name,
        private readonly ?string $apiKey,
        private readonly string $model,
        private readonly string $endpoint,
        private readonly int $timeout,
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function configured(): bool
    {
        return ! empty($this->apiKey);
    }

    public function reply(string $message, string $systemPrompt, array $history = []): string
    {
        // Provider tanpa API key dianggap tidak siap dan dilempar agar dilewati engine.
        if (! $this->configured()) {
            throw new ChatbotException("[{$this->name}] API key belum dikonfigurasi.");
        }

        // Susun percakapan: system prompt, lalu riwayat, lalu pesan terbaru.
        $messages = [['role' => 'system', 'content' => $systemPrompt]];

        foreach ($history as $exchange) {
            $messages[] = ['role' => 'user', 'content' => $exchange['user']];
            $messages[] = ['role' => 'assistant', 'content' => $exchange['bot']];
        }

        $messages[] = ['role' => 'user', 'content' => $message];

        // Panggil API dengan retry ringan; error jaringan dibungkus jadi ChatbotException.
        try {
            $response = Http::timeout($this->timeout)
                ->retry(2, 200, throw: false)
                ->withToken($this->apiKey)
                ->post("{$this->endpoint}/chat/completions", [
                    'model' => $this->model,
                    'temperature' => 0.4,
                    'max_tokens' => 512,
                    'messages' => $messages,
                ]);
        } catch (Throwable $e) {
            throw new ChatbotException("[{$this->name}] request gagal: ".$e->getMessage(), 0, $e);
        }

        // Validasi respons: status HTTP dan isi balasan harus valid.
        if ($response->failed()) {
            throw new ChatbotException("[{$this->name}] mengembalikan HTTP {$response->status()}.");
        }

        $text = $response->json('choices.0.message.content');

        if (! is_string($text) || trim($text) === '') {
            throw new ChatbotException("[{$this->name}] mengembalikan respons kosong.");
        }

        return trim($text);
    }
}