<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use App\Models\ChatLog;
use App\Models\Client;
use App\Models\Document;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Project;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            ['label' => 'Total Proyek', 'value' => (string) Project::count(), 'icon' => 'grid'],
            ['label' => 'Total Klien', 'value' => (string) Client::count(), 'icon' => 'users'],
            ['label' => 'Berita Terbit', 'value' => (string) Post::where('status', 'published')->count(), 'icon' => 'newspaper'],
            ['label' => 'Dokumen', 'value' => (string) Document::count(), 'icon' => 'file-text'],
            ['label' => 'FAQ Aktif', 'value' => (string) Faq::where('is_active', true)->count(), 'icon' => 'message'],
            ['label' => 'Percakapan Chatbot', 'value' => (string) ChatConversation::count(), 'icon' => 'list'],
        ];

        $faqCount = ChatLog::where('source', 'faq')->count();
        $geminiCount = ChatLog::where('source', 'gemini')->count();
        $grokCount = ChatLog::where('source', 'grok')->count();
        $total = max($faqCount + $geminiCount + $grokCount, 1);

        $chatbotSourceBreakdown = [
            'faq' => (int) round($faqCount / $total * 100),
            'gemini' => (int) round($geminiCount / $total * 100),
            'grok' => (int) round($grokCount / $total * 100),
            'total' => $faqCount + $geminiCount + $grokCount,
        ];

        $recentActivity = Post::with('category')
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(fn (Post $post) => [
                'title' => $post->title,
                'type' => 'Berita',
                'badge' => 'default',
                'time' => $post->updated_at?->diffForHumans() ?? '—',
                'status' => $post->status === 'published' ? 'publish' : ($post->status === 'draft' ? 'draft' : 'archived'),
                'statusLabel' => $post->status === 'published' ? 'Terbit' : ($post->status === 'draft' ? 'Draft' : 'Arsip'),
            ])
            ->all();

        return view('admin.dashboard', compact('stats', 'chatbotSourceBreakdown', 'recentActivity'));
    }
}
