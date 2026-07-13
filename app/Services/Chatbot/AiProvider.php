<?php

namespace App\Services\Chatbot;

/**
 * Kontrak umum untuk semua penyedia AI (Gemini, Grok, OpenAI, DeepSeek, dll).
 * Dengan interface ini, ChatbotEngine tidak peduli provider apa yang dipakai.
 */
interface AiProvider
{
    // Kunci provider, dipakai sebagai nilai kolom ChatLog "source".
    public function name(): string;

    // Cek apakah provider punya konfigurasi minimum (API key) untuk dijalankan.
    public function configured(): bool;

    /**
     * Kirim pesan ke model dan kembalikan balasan teks.
     *
     * @param array<int, array{user: string, bot: string}> $history
     * @throws ChatbotException
     */
    public function reply(string $message, string $systemPrompt, array $history = []): string;
}