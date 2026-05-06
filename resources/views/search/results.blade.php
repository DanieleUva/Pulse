<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulse | Esplora Utenti</title>
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
        
        <!-- Header Risultati -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Esplora Pulse</h2>
                <p class="text-slate-500 font-medium">Risultati per: <span class="text-indigo-600 font-bold">"{{ $query }}"</span></p>
            </div>
            <span class="bg-indigo-100 text-indigo-700 px-4 py-1 rounded-full text-xs font-black uppercase">
                {{ $users->count() }} {{ $users->count() == 1 ? 'utente trovato' : 'utenti trovati' }}
            </span>
        </div>

        @if($users->isEmpty())
            <!-- Stato Vuoto -->
            <div class="bg-white/80 backdrop-blur-md p-12 rounded-[2.5rem] text-center shadow-sm border border-white">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-100 rounded-2xl mb-4 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-slate-600 font-bold text-xl">Nessun match!</p>
                <p class="text-slate-400 mt-1">Prova a cercare un nome diverso.</p>
                <a href="/" class="inline-block mt-6 text-indigo-600 font-black text-sm uppercase tracking-widest hover:text-indigo-800 transition">Torna alla Home</a>
            </div>
        @else
            <!-- Lista Utenti -->
            <div class="grid gap-4">
                @foreach($users as $user)
                    <div class="bg-white/80 backdrop-blur-md p-5 rounded-[2rem] shadow-sm border border-white flex items-center justify-between hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-300 group">
                        
                        <!-- Info Utente -->
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <img src="{{ $user->getAvatarUrl() }}" class="w-16 h-16 rounded-2xl object-cover shadow-md border-2 border-slate-50 group-hover:scale-105 transition">
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 {{ auth()->check() && auth()->user()->isFollowing($user) ? 'bg-green-500' : 'bg-indigo-500' }} border-2 border-white rounded-full shadow-sm"></div>
                            </div>
                            <div>
                                <p class="font-black text-slate-900 text-lg leading-tight">{{ $user->name }}</p>
                                <p class="text-sm text-indigo-500 font-bold tracking-tight">@ {{ $user->username }}</p>
                            </div>
                        </div>
                        
                        <!-- Azioni -->
                        <div class="flex items-center space-x-3">
                            @auth
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('user.follow', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-widest transition-all duration-200 active:scale-95
                                            {{ auth()->user()->isFollowing($user) 
                                                ? 'bg-slate-100 text-slate-500 hover:bg-red-50 hover:text-red-500 border border-slate-200' 
                                                : 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-200' }}">
                                            {{ auth()->user()->isFollowing($user) ? 'Seguito' : 'Segui' }}
                                        </button>
                                    </form>
                                @endif
                            @endauth

                            <a href="{{ route('users.show', $user) }}" 
                               class="bg-slate-900 p-3 rounded-2xl text-white hover:bg-slate-800 transition-all shadow-lg shadow-slate-200"
                               title="Vedi Profilo">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>