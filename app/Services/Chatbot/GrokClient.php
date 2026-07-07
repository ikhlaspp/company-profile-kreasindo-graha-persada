<?php

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Client for xAI Grok (OpenAI-compatible chat completions) API integration.
 *
 * Serves as the fallback AI layer when Gemini fails or exhausts its quota.
 * Throws ChatbotException on any failure to signal the orchestrator to provide
 * a static fallback message.
 */
class GrokClient
{
    /**
     * GrokClient constructor.
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
     * Sends a message to the Grok API and retrieves the response.
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
            throw new ChatbotException('Grok API key is not configured.');
        }

        $messages = [['role' => 'system', 'content' => $systemPrompt]];

        foreach ($history as $exchange) {
            $messages[] = ['role' => 'user', 'content' => $exchange['user']];
            $messages[] = ['role' => 'assistant', 'content' => $exchange['bot']];
        }

        $messages[] = ['role' => 'user', 'content' => $message];

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
            throw new ChatbotException('Grok request failed: '.$e->getMessage(), 0, $e);
        }

        if ($response->failed()) {
            throw new ChatbotException("Grok returned HTTP status {$response->status()}.");
        }

        $text = $response->json('choices.0.message.content');

        if (! is_string($text) || trim($text) === '') {
            throw new ChatbotException('Grok returned an empty response.');
        }

        return trim($text);
    }
}
