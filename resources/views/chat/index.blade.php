<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I miei Messaggi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: radial-gradient(circle at top right, #eef2ff 0%, #f1f5f9 50%, #f8fafc 100%);
            background-attachment: fixed;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-900">

    <x-navbar />

    <div class="max-w-2xl mx-auto mt-10 px-4 pb-20">
        <h1 class="text-3xl font-black text-slate-900 mb-8 tracking-tight">I tuoi messaggi</h1>
        
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-white overflow-hidden">
            <div class="divide-y divide-slate-100">
                @forelse($users as $chatUser)
                    <a href="{{ route('chat.show', $chatUser->username) }}" class="flex items-center p-6 hover:bg-indigo-50/30 transition group">
                        <div class="relative">
                            <img src="{{ $chatUser->getAvatarUrl() }}" class="w-16 h-16 rounded-2xl object-cover shadow-md group-hover:scale-105 transition">
                            @if($chatUser->unread_count > 0)
                                <span class="absolute -top-2 -right-2 bg-rose-500 text-white text-[10px] font-black w-6 h-6 flex items-center justify-center rounded-full border-2 border-white animate-bounce">
                                    {{ $chatUser->unread_count }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="ml-5 flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="font-bold text-lg text-slate-900 group-hover:text-indigo-600 transition">{{ $chatUser->name }}</h3>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Apri Chat</span>
                            </div>
                            <p class="text-sm text-slate-500 font-medium italic">
                                @if($chatUser->unread_count > 0)
                                    Hai dei nuovi messaggi da leggere!
                                @else
                                    Clicca per vedere la conversazione
                                @endif
                            </p>
                        </div>
                        
                        <div class="ml-4 opacity-0 group-hover:opacity-100 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="p-16 text-center">
                        <div class="bg-slate-100 w-16 h-16 rounded-3xl flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Ancora nessun messaggio</p>
                        <p class="text-slate-400 text-sm mt-1">Inizia a chattare visitando il profilo di un utente!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</body>
</html>