<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulse | Home</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
    background: radial-gradient(circle at top right, #eef2ff 0%, #f1f5f9 50%, #f8fafc 100%);
    background-attachment: fixed;
    margin: 0;
    padding: 0;
    /* Questo assicura che se la pagina è corta, il fondo sia nero come il footer */
    background-color: #0B1120; 
}
        
        @keyframes progress {
            from { width: 0%; }
            to { width: 100%; }
        }

        .animate-progress {
            animation: progress 5s linear forwards;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-900">

    <x-navbar />

<main class="flex-grow"> <div class="max-w-4xl mx-auto mt-10 px-4 pb-20">      
        <!-- Header con Titolo Moderno -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black tracking-tight text-slate-800">
                Benvenuto su <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Pulse</span>
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Condividi le tue idee con il mondo.</p>
        </div>

        
       <!-- Box Creazione Post -->
        @auth
        <div class="bg-white/80 backdrop-blur-md p-6 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] mb-10 border border-white">
            <div class="flex items-start space-x-4">
                <img src="{{ auth()->user()->getAvatarUrl() }}" class="w-12 h-12 rounded-2xl object-cover shadow-lg border-2 border-white">
                
                <form action="/post" method="POST" enctype="multipart/form-data" class="flex-1">
                    @csrf
                    <textarea name="body" 
                        class="w-full p-4 bg-slate-50/50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 outline-none resize-none transition text-lg placeholder:text-slate-400" 
                        rows="3" 
                        placeholder="A cosa stai pensando, {{ auth()->user()->name }}?" 
                        required></textarea>
                    
                    <div class="flex items-center justify-between mt-4">
                        <!-- Tasto Immagine Minimal -->
                        <label class="group flex items-center space-x-2 cursor-pointer outline-none">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-black text-slate-400 group-hover:text-indigo-600 transition tracking-tight">Aggiungi foto</span>
                            <input type="file" name="image" accept="image/*" class="hidden" onchange="updateFileName(this)">
                        </label>

                        <!-- Status File (Appare quando selezioni una foto) -->
                        <div id="file-chosen" class="hidden text-xs font-bold text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full animate-bounce">
                            Foto pronta! ✨
                        </div>

                        <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg shadow-slate-200 active:scale-95">
                            Pubblica
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function updateFileName(input) {
                const status = document.getElementById('file-chosen');
                if (input.files && input.files[0]) {
                    status.classList.remove('hidden');
                } else {
                    status.classList.add('hidden');
                }
            }
        </script>
        @endauth

        <!-- Sezione Feed -->
        <div class="flex items-center space-x-4 mb-8 px-2">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Feed Recente</h3>
            <div class="h-[1px] flex-1 bg-slate-200"></div>
        </div>

        SEZIONE MOMENTI
        
       <div x-data="{ open: false, activeImage: '', activeUser: '' }" class="mb-10">
    
    <!-- Titolo Sezione (Opzionale, molto pulito) -->
    <div class="flex items-center justify-between mb-4 px-2">
        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Momenti Recenti</h3>
    </div>

    <!-- Container Scorrevole -->
    <div class="flex space-x-5 overflow-x-auto pb-4 no-scrollbar items-start">
        
        <!-- TASTO AGGIUNGI (TU) -->
        <div class="flex-shrink-0 flex flex-col items-center group">
            <form action="{{ route('moments.store') }}" method="POST" enctype="multipart/form-data" id="moment-form">
                @csrf
                <input type="file" name="image" id="moment-input" class="hidden" onchange="document.getElementById('moment-form').submit()">
                
                <div onclick="document.getElementById('moment-input').click()" 
                     class="relative w-20 h-20 rounded-[2.5rem] bg-slate-100 flex items-center justify-center cursor-pointer border-2 border-dashed border-slate-300 group-hover:border-indigo-500 group-hover:bg-indigo-50/50 transition-all duration-300 overflow-hidden shadow-sm">
                    
                    <!-- Anteprima del tuo avatar sfuocata sullo sfondo (molto pro) -->
                    <img src="{{ auth()->user()->getAvatarUrl() }}" class="absolute inset-0 w-full h-full object-cover opacity-20 blur-[2px]">
                    
                    <!-- Plus Icon -->
                    <div class="relative z-10 w-8 h-8 bg-white rounded-2xl shadow-md flex items-center justify-center text-indigo-600 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                </div>
            </form>
            <span class="text-[10px] font-black mt-3 text-slate-400 uppercase tracking-wider">Aggiungi</span>
        </div>

        <!-- LISTA MOMENTI ALTRI UTENTI -->
        @foreach($moments as $moment)
            <div class="flex-shrink-0 flex flex-col items-center cursor-pointer group" 
                 @click="activeImage = '{{ asset('storage/' . $moment->image_path) }}'; activeUser = '{{ $moment->user->username }}'; open = true">
                
                <!-- Ring Gradiente -->
                <div class="p-[3px] rounded-[2.6rem] bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 group-hover:rotate-12 transition-all duration-500 shadow-lg shadow-indigo-100">
                    <div class="bg-white p-1 rounded-[2.4rem]">
                        <img src="{{ $moment->user->getAvatarUrl() }}" 
                             class="w-16 h-16 rounded-[2.2rem] object-cover border-2 border-white group-hover:scale-105 transition duration-300">
                    </div>
                </div>
                
                <span class="text-[10px] font-black mt-3 text-slate-700 uppercase tracking-tighter">{{ $moment->user->username }}</span>
            </div>
        @endforeach
    </div>

    <!-- MODALE FULLSCREEN (Stile Storie) -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-110"
         x-transition:enter-end="opacity-100 scale-100"
         class="fixed inset-0 z-[999] flex items-center justify-center bg-slate-900/95 backdrop-blur-xl p-0 md:p-4" 
         @keydown.escape.window="open = false" 
         style="display: none;">
        
        <!-- Chiudi -->
        <button @click="open = false" class="absolute top-8 right-8 z-50 text-white/50 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="max-w-[450px] w-full h-full md:h-[85vh] relative bg-black md:rounded-[3rem] overflow-hidden shadow-[0_0_80px_rgba(0,0,0,0.5)]">
            <!-- Immagine Storia -->
            <img :src="activeImage" class="w-full h-full object-cover">
            
            <!-- Overlay Info Utente -->
            <div class="absolute top-0 left-0 right-0 p-6 bg-gradient-to-b from-black/60 to-transparent">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full border-2 border-white/20 overflow-hidden">
                         <img :src="activeImage" class="w-full h-full object-cover blur-sm"> <!-- Placeholder o avatar -->
                    </div>
                    <span class="text-white font-bold text-sm tracking-tight" x-text="activeUser"></span>
                </div>
                
                <!-- Barra Progresso -->
                <div class="flex space-x-1 mt-4">
                    <div class="h-1 flex-1 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full bg-white w-full animate-progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

FINE SEZIONE MOMENTI

        @foreach ($posts as $post)
    <!-- Modifica la riga 199 così: -->
<div id="post-{{ $post->id }}" class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] mb-10 border border-slate-100 overflow-hidden transition-all duration-500 hover:shadow-indigo-500/10 group">
        
        <!-- Header Post -->
        <div class="p-8 flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('users.show', $post->user) }}" class="relative group/avatar">
                    <img src="{{ $post->user->getAvatarUrl() }}" class="w-14 h-14 rounded-[1.5rem] object-cover border-2 border-white shadow-md transition-all duration-300 group-hover/avatar:rotate-3 group-hover/avatar:scale-105">
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 border-4 border-white rounded-full shadow-sm"></div>
                </a>
                <div class="flex flex-col ml-4">
                    <a href="{{ route('users.show', $post->user) }}" class="font-black text-slate-900 hover:text-indigo-600 transition text-lg tracking-tight">
                        {{ $post->user->username }}
                    </a>
                    <span class="text-slate-400 text-[10px] uppercase font-black tracking-[0.1em] mt-0.5">{{ $post->created_at->diffForHumans() }}</span>
                </div>
            </div>

            @if(auth()->check() && auth()->id() === $post->user_id)
                <form action="{{ route('post.destroy', $post) }}" method="POST" onsubmit="return confirm('Vuoi davvero eliminare questo post?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-3 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-2xl transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            @endif
        </div>
        
        <!-- Contenuto Post -->
        <div class="px-8 pb-6">
            <p class="text-slate-600 leading-[1.6] text-[18px] font-medium mb-6">
                {{ $post->body }}
            </p>

            @if($post->image)
                <div class="relative group/image overflow-hidden rounded-[2rem] border border-slate-100 shadow-sm">
                    <img src="{{ Storage::url($post->image) }}" class="w-full h-auto max-h-[600px] object-cover transition-transform duration-700 group-hover/image:scale-[1.02]">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover/image:opacity-100 transition-opacity"></div>
                </div>
            @endif
        </div>

        <!-- Interazioni -->
        <div class="px-8 py-5 flex items-center space-x-8 border-t border-slate-50/60 bg-white">
            <!-- Like -->
            <form action="{{ route('post.like', $post) }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center space-x-2.5 group/btn transition {{ auth()->check() && $post->isLikedBy(auth()->user()) ? 'text-red-500' : 'text-slate-400' }}">
                    <div class="p-2.5 rounded-2xl group-hover/btn:bg-red-50 transition-all duration-200 active:scale-90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ auth()->check() && $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <span class="font-black text-sm tracking-tight">{{ $post->likes->count() }}</span>
                </button>
            </form>

            <!-- Views -->
            <div class="flex items-center space-x-2.5 text-slate-400 group/btn">
                <div class="p-2.5 rounded-2xl group-hover/btn:bg-slate-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <span class="font-black text-sm tracking-tight">{{ $post->views_count ?? 0 }}</span>
            </div>

            <!-- Comment Counter -->
            <div class="flex items-center space-x-2.5 text-slate-400 group/btn">
                <div class="p-2.5 rounded-2xl group-hover/btn:bg-indigo-50 group-hover/btn:text-indigo-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <span class="font-black text-sm tracking-tight">{{ $post->comments->count() }}</span>
            </div>
        </div>

        <!-- Area Commenti -->
        <div class="bg-slate-50/40 p-8 border-t border-slate-100" x-data="{ showAll: false }">
            <div class="space-y-5 mb-8">
                @foreach($post->comments as $index => $comment)
                    <div class="flex space-x-4 items-start" 
                         x-show="showAll || {{ $index }} < 2" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4">
                        
                        <img src="{{ $comment->user->getAvatarUrl() }}" class="w-10 h-10 rounded-[1rem] object-cover border-2 border-white shadow-sm flex-shrink-0">
                        
                        <div class="flex-1 bg-white p-5 rounded-[1.5rem] shadow-sm border border-slate-100 relative group/comment transition-hover hover:border-indigo-100">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-black text-indigo-600 uppercase tracking-wider">@ {{ $comment->user->username }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-[14px] text-slate-600 leading-relaxed font-medium">{{ $comment->body }}</p>

                            @auth
                                @if(auth()->id() === $comment->user_id)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="absolute -right-2 -top-2 opacity-0 group-hover/comment:opacity-100 transition-all duration-200">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-white text-red-500 shadow-xl p-1.5 rounded-xl border border-red-50 hover:bg-red-50 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            @if($post->comments->count() > 2)
                <div class="mb-8 pl-14">
                    <button @click="showAll = !showAll" 
                            class="group/more py-2 px-4 bg-white rounded-full border border-slate-200 text-[11px] font-black text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all duration-300 flex items-center space-x-2 shadow-sm">
                        <span x-text="showAll ? 'NASCONDI' : 'MOSTRA TUTTI I {{ $post->comments->count() }} COMMENTI'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transition-transform duration-300" :class="showAll ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
            @endif

            @auth
                <form action="{{ route('comments.store', $post) }}" method="POST" class="flex items-center space-x-4 pl-2">
                    @csrf
                    <div class="flex-1 relative group/input">
                        <input type="text" name="body" placeholder="Scrivi un pensiero gentile..." 
                            class="w-full bg-white border border-slate-200 rounded-[1.5rem] pl-6 pr-20 py-4 text-sm focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 outline-none transition-all shadow-sm font-medium">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 bg-slate-900 text-white px-5 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-600 transition-colors shadow-lg shadow-slate-200">
                            Invia
                        </button>
                    </div>
                </form>
            @endauth
        </div>
    </div>
@endforeach

</div> </main> <x-footer />

</body>
</html>