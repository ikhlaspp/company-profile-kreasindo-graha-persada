<?php

namespace App\Providers;

use App\Services\Chatbot\ChatbotEngine;
use App\Services\Chatbot\FaqMatcher;
use App\Services\Chatbot\KgpContext;
use App\Services\Chatbot\ProviderFactory;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // FaqMatcher dan ProviderFactory dibangun dari nilai config chatbot.
        $this->app->singleton(FaqMatcher::class, fn () => new FaqMatcher(
            (int) config('services.chatbot.faq_threshold', 2),
        ));

        $this->app->singleton(ProviderFactory::class, fn () => new ProviderFactory(
            (int) config('services.chatbot.timeout', 20),
        ));

        // Engine dirakit dengan rantai provider sesuai urutan di config "chain".
        $this->app->singleton(ChatbotEngine::class, function ($app) {
            $factory = $app->make(ProviderFactory::class);

            return new ChatbotEngine(
                $app->make(FaqMatcher::class),
                $app->make(KgpContext::class),
                $factory->chain((array) config('services.chatbot.chain', [])),
            );
        });
    }

    public function boot(): void
    {
        // Set locale tanggal ke Bahasa Indonesia untuk seluruh aplikasi.
        Carbon::setLocale('id');
    }
}