<?php

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Client for Google Gemini (2.5 Flash) API integration.
 *
 * Acts as the primary AI layer grounded with the company context.
 * Throws ChatbotException on any failure (e.g., missing API key, quota limits,
 * timeout, or malformed responses) to allow fallback mechanisms to take over.
 */
class GeminiClient
{
    /**
     * GeminiClient constructor.
     *
     * @param string|null $apiKey
     * @param string $model
     * @param string $endpoint
     * @param int $timeout
     */
    public function __construct(
        private readonly ?string $apiKey,
        private readonly string $model,
        private readonly string $endpoint,
        private readonly int $timeout,
    ) {}

    /**
     * Checks if the client is properly configured with an API key.
     *
     * @return bool
     */
    public function configured(): bool
    {
        return ! empty($this->apiKey);
    }

    /**
     * Sends a message to the Gemini API and retrieves the response.
     *
     * @param string $message The current user message.
     * @param string $systemPrompt The grounding context for the AI.
     * @param array<int, array{user: string, bot: string}> $history Previous conversation exchanges.
     * @return string The generated response.
     *
     * @throws ChatbotException
     */
    public function reply(string $message, string $systemPrompt, array $history = []): string
    {
        if (! $this->configured()) {
            throw new ChatbotException('Gemini API key is not configured.');
        }

        $contents = [];

        foreach ($history as $exchange) {
            $contents[] = ['role' => 'user', 'parts' => [['text' => $exchange['user']]]];
            $contents[] = ['role' => 'model', 'parts' => [['text' => $exchange['bot']]]];
        }

        $contents[] = ['role' => 'user', 'parts' => [['text' => $message]]];

        try {
            $response = Http::timeout($this->timeout)
                ->retry(2, 200, throw: false)
                ->withQueryParameters(['key' => $this->apiKey])
                ->post("{$this->endpoint}/models/{$this->model}:generateContent", [
                    'system_instruction' => [
                        'parts' => [['text' => $systemPrompt]],
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.4,
                        'maxOutputTokens' => 512,
                    ],
                ]);
        } catch (Throwable $e) {
            throw new ChatbotException('Gemini request failed: '.$e->getMessage(), 0, $e);
        }

        if ($response->failed()) {
            throw new ChatbotException("Gemini returned HTTP status {$response->status()}.");
        }

        $text = $response->json('candidates.0.content.parts.0.text');

        if (! is_string($text) || trim($text) === '') {
            throw new ChatbotException('Gemini returned an empty response.');
        }

        return trim($text);
    }
}
