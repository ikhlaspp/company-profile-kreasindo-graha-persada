<?php

namespace App\Http\Controllers;

use App\Services\Chatbot\ChatbotEngine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Controller handling public chatbot interactions.
 *
 * Validates input, rate-limits requests per session, and delegates
 * the multi-layer answer logic and logging to the ChatbotEngine.
 */
class ChatController extends Controller
{
    /**
     * Process an incoming chatbot message and return a JSON response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Services\Chatbot\ChatbotEngine $engine
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request, ChatbotEngine $engine): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'session_id' => ['required', 'string', 'max:64'],
        ]);

        $limit = (int) config('services.chatbot.rate_limit', 20);
        $key = 'chatbot:'.$data['session_id'];

        if (RateLimiter::tooManyAttempts($key, $limit)) {
            return response()->json([
                'reply' => 'Terlalu banyak pesan dalam waktu singkat. Mohon tunggu sebentar lalu coba lagi.',
                'source' => 'fallback',
            ], 429);
        }

        RateLimiter::hit($key, 60);

        $result = $engine->handle(
            message: $data['message'],
            sessionId: $data['session_id'],
            ip: $request->ip(),
            userAgent: $request->userAgent(),
        );

        return response()->json($result);
    }
}
