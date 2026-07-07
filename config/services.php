<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Chatbot Hybrid KGP
    |--------------------------------------------------------------------------
    | "chain" menentukan urutan lapisan AI setelah FAQ (tukar bebas lewat .env).
    | "providers" adalah registry semua provider yang tersedia.
    | driver "gemini" = format native Google, driver "openai" = format /chat/completions.
    */
    'chatbot' => [
        'rate_limit'    => (int) env('CHATBOT_RATE_LIMIT', 20),
        'timeout'       => (int) env('CHATBOT_TIMEOUT', 20),
        'faq_threshold' => (int) env('CHATBOT_FAQ_THRESHOLD', 2),

        'chain' => array_values(array_filter(array_map('trim',
            explode(',', (string) env('CHATBOT_CHAIN', 'gemini,grok'))
        ))),

        'providers' => [
            'gemini' => [
                'driver'   => 'gemini',
                'key'      => env('GEMINI_API_KEY'),
                'model'    => env('GEMINI_MODEL', 'gemini-2.5-flash'),
                'endpoint' => env('GEMINI_ENDPOINT', 'https://generativelanguage.googleapis.com/v1beta'),
            ],
            'grok' => [
                'driver'   => 'openai',
                'key'      => env('GROK_API_KEY'),
                'model'    => env('GROK_MODEL', 'grok-2-latest'),
                'endpoint' => env('GROK_ENDPOINT', 'https://api.x.ai/v1'),
            ],
            'openai' => [
                'driver'   => 'openai',
                'key'      => env('OPENAI_API_KEY'),
                'model'    => env('OPENAI_MODEL', 'gpt-4o-mini'),
                'endpoint' => env('OPENAI_ENDPOINT', 'https://api.openai.com/v1'),
            ],
            'deepseek' => [
                'driver'   => 'openai',
                'key'      => env('DEEPSEEK_API_KEY'),
                'model'    => env('DEEPSEEK_MODEL', 'deepseek-chat'),
                'endpoint' => env('DEEPSEEK_ENDPOINT', 'https://api.deepseek.com/v1'),
            ],
        ],
    ],

];
