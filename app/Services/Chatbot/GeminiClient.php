<?php

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Klien khusus Google Gemini (format generateContent, berbeda dari OpenAI).
 * API key dikirim sebagai query parameter, bukan bearer token.
 */
class GeminiClient implements AiProvider
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
        // Provider tanpa API key dilempar agar dilewati engine.
        if (! $this->configured()) {
            throw new ChatbotException("[{$this->name}] Gemini API key belum dikonfigurasi.");
        }

        // Gemini memakai peran "model" untuk balasan bot; susun riwayat lalu pesan terbaru.
        $contents = [];

        foreach ($history as $exchange) {
            $contents[] = ['role' => 'user', 'parts' => [['text' => $exchange['user']]]];
            $contents[] = ['role' => 'model', 'parts' => [['text' => $exchange['bot']]]];
        }

        $contents[] = ['role' => 'user', 'parts' => [['text' => $message]]];

        // Panggil endpoint generateContent; system prompt dikirim terpisah.
        try {
            $response = Http::timeout($this->timeout)
                ->retry(2, 200, throw: false)
                ->withQueryParameters(['key' => $this->apiKey])
                ->post("{$this->endpoint}/models/{$this->model}:generateContent", [
                    'system_instruction' => ['parts' => [['text' => $systemPrompt]]],
                    'contents' => $contents,
                    'generationConfig' => ['temperature' => 0.4, 'maxOutputTokens' => 512],
                ]);
        } catch (Throwable $e) {
            throw new ChatbotException("[{$this->name}] request gagal: ".$e->getMessage(), 0, $e);
        }

        // Validasi respons: status HTTP dan isi balasan harus valid.
        if ($response->failed()) {
            throw new ChatbotException("[{$this->name}] mengembalikan HTTP {$response->status()}.");
        }

        $text = $response->json('candidates.0.content.parts.0.text');

        if (! is_string($text) || trim($text) === '') {
            throw new ChatbotException("[{$this->name}] mengembalikan respons kosong.");
        }

        return trim($text);
    }
}