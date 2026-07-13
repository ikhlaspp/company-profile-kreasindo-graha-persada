<?php

namespace App\Services\Chatbot;

use RuntimeException;

/**
 * Exception thrown when an upstream AI provider fails.
 *
 * Indicates that a provider is unavailable, misconfigured, or has encountered
 * an error, signaling the orchestrator to fall back to the next available layer.
 */
class ChatbotException extends RuntimeException {}
