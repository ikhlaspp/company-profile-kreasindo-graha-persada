@php
    // Chatbot settings (Task 3.6) — cached to avoid a query on every page render.
    $chat = \Illuminate\Support\Facades\Cache::remember('chatbot.widget_settings', now()->addMinutes(10), function () {
        $s = \App\Models\Setting::whereIn('key', ['chatbot_enabled', 'chatbot_greeting'])->pluck('value', 'key');

        return [
            'enabled' => ! isset($s['chatbot_enabled']) || (bool) $s['chatbot_enabled'],
            'greeting' => $s['chatbot_greeting'] ?? 'Halo! Ada yang bisa dibantu seputar layanan KGP?',
        ];
    });
@endphp

@if ($chat['enabled'])
<div x-data="chatbox(@js($chat['greeting']))" class="fixed bottom-6 right-6 z-50">
    <!-- Chat Button -->
    <button @click="open = !open" x-show="!open" class="bg-brass-500 hover:bg-brass-300 text-navy-900 w-14 h-14 rounded-full shadow-lg flex items-center justify-center transition-transform hover:scale-105 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500 focus-visible:ring-offset-2" aria-label="Buka chat">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
    </button>

    <!-- Chat Panel -->
    <div x-show="open" x-transition class="bg-white rounded-sm shadow-xl w-[calc(100vw-3rem)] sm:w-96 flex flex-col border border-line overflow-hidden" style="height: min(500px, calc(100vh - 6rem)); display: none;">
        <!-- Header -->
        <div class="bg-navy-900 text-white px-4 py-3.5 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="relative flex w-2.5 h-2.5" aria-hidden="true">
                    <span class="absolute inline-flex h-full w-full rounded-full bg-success opacity-60 animate-ping"></span>
                    <span class="relative inline-flex rounded-full w-2.5 h-2.5 bg-success"></span>
                </span>
                <div class="leading-tight">
                    <div class="font-sans font-semibold text-sm">KGP Assistant</div>
                    <div class="text-[11px] text-slate-400">Respon cepat 24/7</div>
                </div>
            </div>
            <button @click="open = false" class="text-slate-300 hover:text-white cursor-pointer p-1" aria-label="Tutup chat">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 p-4 overflow-y-auto bg-paper flex flex-col space-y-3" x-ref="messages">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.from === 'user' ? 'self-end bg-navy-800 text-white rounded-br-none' : 'self-start bg-paper2 text-ink border border-line rounded-bl-none'" class="px-4 py-2.5 rounded-lg max-w-[85%] text-sm leading-relaxed whitespace-pre-line">
                    <span x-text="msg.text"></span>
                </div>
            </template>
            <!-- Typing indicator -->
            <div x-show="loading" class="self-start bg-paper2 text-ink border border-line px-4 py-3 rounded-lg rounded-bl-none" style="display: none;">
                <div class="flex items-center gap-1">
                    <span class="h-2 w-2 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="h-2 w-2 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="h-2 w-2 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 300ms"></span>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-t border-line flex items-center gap-2">
            <input x-model="input" @keydown.enter="send" :disabled="loading" type="text" placeholder="Tulis pesan..." aria-label="Tulis pesan" class="flex-1 bg-paper border border-line rounded-full px-4 py-2.5 text-sm focus:outline-none focus:border-brass-500 focus:ring-2 focus:ring-brass-300/50 disabled:opacity-60">
            <button @click="send" :disabled="loading" class="bg-brass-500 hover:bg-brass-300 text-navy-900 rounded-full w-10 h-10 flex items-center justify-center flex-shrink-0 cursor-pointer disabled:opacity-60 disabled:cursor-default focus:outline-none focus-visible:ring-2 focus-visible:ring-brass-500" aria-label="Kirim">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chatbox', (greeting) => ({
            open: false,
            input: '',
            loading: false,
            sessionId: '',
            messages: [
                { from: 'bot', text: greeting }
            ],
            init() {
                // Persist a session id per browser tab so the conversation stays linked.
                this.sessionId = sessionStorage.getItem('kgp_chat_session');
                if (!this.sessionId) {
                    this.sessionId = (crypto.randomUUID ? crypto.randomUUID() : 'sess-' + Date.now() + '-' + Math.random().toString(16).slice(2)).slice(0, 64);
                    sessionStorage.setItem('kgp_chat_session', this.sessionId);
                }
            },
            async send() {
                const text = this.input.trim();
                if (text === '' || this.loading) return;

                this.messages.push({ from: 'user', text });
                this.input = '';
                this.loading = true;
                this.scrollToBottom();

                try {
                    const res = await fetch('{{ route('chat.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ message: text, session_id: this.sessionId }),
                    });

                    const data = await res.json().catch(() => ({}));
                    this.messages.push({
                        from: 'bot',
                        text: data.reply || 'Maaf, terjadi kendala. Silakan coba lagi.',
                    });
                } catch (e) {
                    this.messages.push({
                        from: 'bot',
                        text: 'Maaf, koneksi bermasalah. Silakan coba lagi atau hubungi kami via halaman Kontak.',
                    });
                } finally {
                    this.loading = false;
                    this.scrollToBottom();
                }
            },
            scrollToBottom() {
                this.$nextTick(() => {
                    const el = this.$refs.messages;
                    if (el) el.scrollTop = el.scrollHeight;
                });
            }
        }))
    });
</script>
@endif
