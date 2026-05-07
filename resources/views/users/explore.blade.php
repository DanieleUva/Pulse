<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esplora Persone | Pulse</title>
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

    <div class="max-w-6xl mx-auto mt-12 px-4 pb-20">
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Esplora la Community</h1>
            <p class="text-slate-500 font-medium mt-2">Trova nuove persone da seguire e con cui scambiare idee.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($users as $user)
                <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] p-6 shadow-sm border border-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col items-center">
                        <a href="{{ route('users.show', $user->username) }}" class="relative group">
                            <img src="{{ $user->getAvatarUrl() }}" 
                                 class="w-24 h-24 rounded-[2rem] object-cover shadow-lg border-4 border-white group-hover:ring-4 group-hover:ring-indigo-500/10 transition-all">
                        </a>

                        <h2 class="mt-4 text-xl font-black text-slate-900">{{ $user->name }}</h2>
                        <p class="text-indigo-600 font-bold text-sm">@ {{ $user->username }}</p>
                        
                        @if($user->location)
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-1">
                            📍 {{ $user->location }}
                        </p>
                        @endif

                        <p class="mt-4 text-slate-600 text-sm text-center line-clamp-2 h-10 italic">
                            {{ $user->bio ?? 'Nessuna biografia ancora...' }}
                        </p>

                        <div class="mt-6 w-full space-y-3">
                            
                            <form action="{{ route('user.follow', $user) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" 
                                    class="w-full py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all duration-200 active:scale-95 shadow-md
                                    {{ auth()->user()->isFollowing($user) 
                                        ? 'bg-slate-100 text-slate-500 hover:bg-red-50 hover:text-red-500 border border-slate-200' 
                                        : 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-indigo-100' }}">
                                    {{ auth()->user()->isFollowing($user) ? 'Seguito' : 'Segui' }}
                                </button>
                            </form>

                            <div class="flex gap-2">
                                <a href="{{ route('users.show', $user->username) }}" class="flex-1 bg-slate-900 text-white text-center py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-800 transition">
                                    Profilo
                                </a>
                                <a href="{{ route('chat.show', $user->username) }}" class="px-4 bg-indigo-50 text-indigo-600 py-3 rounded-xl hover:bg-indigo-600 hover:text-white transition group">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($users->isEmpty())
            <div class="text-center py-20">
                <p class="text-slate-400 font-bold text-lg italic">Sei il primo qui! Non ci sono ancora altri utenti. 😶‍🌫️</p>
            </div>
        @endif
    </div>
</body>
</html>