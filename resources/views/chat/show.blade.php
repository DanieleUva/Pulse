<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat con {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: radial-gradient(circle at top right, #eef2ff 0%, #f1f5f9 50%, #f8fafc 100%);
            background-attachment: fixed;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-900">

    <x-navbar /> <!-- Questo dovrebbe funzionare se lo usi nelle altre pagine -->

    <div class="max-w-2xl mx-auto mt-10 px-4">
        <div class="bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-2xl border border-white overflow-hidden flex flex-col h-[80vh]">
            
            <!-- Header Chat -->
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-white/50">
                <div class="flex items-center space-x-4">
                    <img src="{{ $user->getAvatarUrl() }}" class="w-12 h-12 rounded-2xl object-cover shadow-md">
                    <div>
                        <h2 class="font-black text-slate-900 leading-none">{{ $user->name }}</h2>
                        <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">Chat Attiva</span>
                    </div>
                </div>
                <a href="/profilo/{{ $user->username }}" class="text-slate-400 hover:text-slate-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Area Messaggi -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50/30" id="chat-window">
                @forelse($messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] px-6 py-3 rounded-[2rem] shadow-sm text-sm font-medium
                            {{ $message->sender_id === auth()->id() 
                                ? 'bg-indigo-600 text-white rounded-tr-none' 
                                : 'bg-white text-slate-700 rounded-tl-none border border-slate-100' }}">
                            {{ $message->body }}
                            <div class="text-[9px] mt-1 opacity-70 {{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                                {{ $message->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-full text-slate-400 opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="font-bold uppercase tracking-widest text-xs">Invia il primo messaggio!</p>
                    </div>
                @endforelse
            </div>

            <!-- Input Messaggio -->
            <div class="p-6 bg-white border-t border-slate-100">
                <form action="{{ route('chat.store', $user->username) }}" method="POST" class="flex space-x-3">
                    @csrf
                    <input type="text" name="body" placeholder="Scrivi a {{ $user->name }}..." 
                        class="flex-1 bg-slate-100 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-indigo-500/20 outline-none transition font-medium" autocomplete="off" required>
                    <button type="submit" class="bg-slate-900 text-white p-4 rounded-2xl hover:bg-indigo-600 transition shadow-lg active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-scroll in fondo alla chat all'apertura
        const chatWindow = document.getElementById('chat-window');
        chatWindow.scrollTop = chatWindow.scrollHeight;
    </script>

</body>
</html>