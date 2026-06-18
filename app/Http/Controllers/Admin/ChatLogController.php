<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\ChatLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatLogController extends Controller
{
    public function index(Request $request): View
    {
        $conversations = ChatConversation::query()
            ->withCount('logs')
            ->when($request->filled('q'), fn ($q) => $q->where('session_id', 'like', '%'.$request->string('q').'%'))
            ->latest('last_activity_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.chat-logs.index', compact('conversations'));
    }

    public function show(ChatConversation $conversation): View
    {
        $messages = $conversation->logs()
            ->orderBy('created_at')
            ->get()
            ->flatMap(function (ChatLog $log) {
                $bubbles = [[
                    'role' => 'user',
                    'text' => $log->user_message,
                    'time' => $log->created_at?->format('H:i'),
                ]];

                if ($log->bot_reply) {
                    $bubbles[] = [
                        'role' => 'bot',
                        'text' => $log->bot_reply,
                        'time' => $log->created_at?->format('H:i'),
                        'source' => $log->source,
                    ];
                }

                return $bubbles;
            })
            ->all();

        return view('admin.chat-logs.show', compact('conversation', 'messages'));
    }
}
