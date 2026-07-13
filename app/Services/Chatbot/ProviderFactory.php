<?php

namespace App\Services\Chatbot;

use InvalidArgumentException;

/**
 * Membangun instance provider dari config/services.php berdasarkan namanya.
 * Driver "gemini" memakai GeminiClient, driver "openai" memakai OpenAiCompatibleClient.
 */
class ProviderFactory
{
    public function __construct(private readonly int $timeout) {}

    public function make(string $name): AiProvider
    {
        // Ambil definisi provider; wajib ada di config agar tidak salah ketik.
        $config = config("services.chatbot.providers.{$name}");

        if (! is_array($config)) {
            throw new InvalidArgumentException("Provider chatbot [{$name}] tidak terdaftar di config/services.php.");
        }

        // Normalisasi nilai konfigurasi sebelum membuat klien.
        $driver   = $config['driver'] ?? 'openai';
        $key      = $config['key'] ?? null;
        $model    = (string) ($config['model'] ?? '');
        $endpoint = rtrim((string) ($config['endpoint'] ?? ''), '/');

        // Petakan driver ke class klien yang sesuai.
        return match ($driver) {
            'gemini' => new GeminiClient($name, $key, $model, $endpoint, $this->timeout),
            'openai' => new OpenAiCompatibleClient($name, $key, $model, $endpoint, $this->timeout),
            default  => throw new InvalidArgumentException("Driver [{$driver}] tidak dikenal untuk provider [{$name}]."),
        };
    }

    /**
     * Bangun rantai provider terurut dari daftar nama (mis. ["gemini", "grok"]).
     *
     * @param array<int, string> $names
     * @return array<int, AiProvider>
     */
    public function chain(array $names): array
    {
        return array_values(array_map(fn (string $name) => $this->make($name), $names));
    }
}