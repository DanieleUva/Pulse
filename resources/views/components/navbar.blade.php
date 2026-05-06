<nav class="bg-slate-950 border-b border-indigo-900/30 sticky top-0 z-50 shadow-2xl shadow-indigo-950/20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex justify-between h-20 items-center">
            
            <!-- Logo con Gradiente -->
            <div class="flex items-center">
                <a href="/" class="group flex items-center space-x-1">
                    <span class="text-2xl font-black tracking-tighter text-white transition group-hover:text-indigo-400">
                        PULSE
                    </span>
                    <div class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_15px_#6366f1]"></div>
                </a>
            </div>

            <!-- Barra di Ricerca Centrale -->
            <div class="hidden md:flex flex-1 max-w-md mx-8">
                <form action="/search" method="GET" class="w-full relative group">
                    <input type="text" name="query" placeholder="Cerca persone o post..." 
                        class="w-full bg-slate-900 border border-slate-800 text-slate-300 rounded-2xl px-5 py-2 pl-11 focus:ring-2 focus:ring-indigo-500 focus:bg-slate-800 outline-none transition-all placeholder:text-slate-500">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-indigo-400 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>
            </div>

            @auth
    @php
        $unreadGlobal = \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count();
    @endphp

    <a href="{{ route('chat.index') }}" class="relative p-2 text-slate-600 hover:text-indigo-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        
        @if($unreadGlobal > 0)
            <span class="absolute top-1 right-1 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-500 text-[9px] text-white font-black items-center justify-center">
                    {{ $unreadGlobal }}
                </span>
            </span>
        @endif
    </a>
@endauth

            <!-- Menu Destro -->
            <div class="flex items-center space-x-5">
                @auth
                    <!-- Link Profilo Scurito -->
                    <a href="{{ route('users.show', auth()->user()) }}" 
                       class="flex items-center space-x-3 p-1.5 pr-4 rounded-2xl bg-slate-900 border border-slate-800 hover:border-indigo-500/50 hover:bg-slate-800 transition-all duration-300 group">
                       
                        <div class="relative">
                            <img src="{{ auth()->user()->getAvatarUrl() }}" 
                                 class="w-10 h-10 rounded-xl object-cover border-2 border-slate-700 group-hover:border-indigo-400 transition" 
                                 alt="Mio Profilo">
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-indigo-500 border-2 border-slate-950 rounded-full"></span>
                        </div>

                        <div class="text-left hidden md:block">
                            <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest leading-none">Member</p>
                            <p class="text-sm text-white font-bold">@ {{ auth()->user()->username }}</p>
                        </div>
                    </a>

                    <!-- Separatore -->
                    <div class="h-6 w-[1px] bg-slate-800 hidden md:block"></div>

                    <!-- Logout -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2.5 text-slate-500 hover:text-red-400 hover:bg-red-950/30 rounded-xl transition-all group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-black text-slate-300 hover:text-white transition">Accedi</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl text-sm font-black hover:bg-indigo-500 shadow-lg shadow-indigo-900/20 transition-all">
                        Unisciti
                    </a>
                @endauth
            </div>

        </div>
    </div>
</nav>