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

    <div class="max-w-2xl mx-auto mt-10 px-4 pb-20">
        
        <!-- Header con Titolo Moderno -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black tracking-tight text-slate-800">
                Benvenuto su <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Pulse</span>
            </h1>
            <p class="text-slate-500 mt-2 font-medium">Condividi le tue idee con il mondo.</p>
        </div>

        <!-- Box Creazione Post -->
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
        
        <div x-data="{ open: false, activeImage: '' }" class="flex space-x-4 overflow-x-auto pb-6 mb-8 no-scrollbar">
    <div class="flex-shrink-0 flex flex-col items-center">
        <form action="{{ route('moments.store') }}" method="POST" enctype="multipart/form-data" id="moment-form">
            @csrf
            <input type="file" name="image" id="moment-input" class="hidden" onchange="document.getElementById('moment-form').submit()">
            <div onclick="document.getElementById('moment-input').click()" 
                 class="w-16 h-16 rounded-full border-2 border-dashed border-slate-300 flex items-center justify-center cursor-pointer hover:border-indigo-500 transition group">
                 <span class="text-slate-400 group-hover:text-indigo-500 font-bold text-2xl">+</span>
            </div>
        </form>
        <span class="text-[10px] font-bold mt-2 text-slate-500">Tu</span>
    </div>

    @foreach($moments as $moment)
        <div class="flex-shrink-0 flex flex-col items-center cursor-pointer" 
             @click="activeImage = '{{ asset('storage/' . $moment->image_path) }}'; open = true">
            <div class="p-1 rounded-full bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 hover:scale-105 transition">
                <div class="bg-white p-0.5 rounded-full">
                    <img src="{{ $moment->user->getAvatarUrl() }}" class="w-14 h-14 rounded-full object-cover border-2 border-white">
                </div>
            </div>
            <span class="text-[10px] font-bold mt-2 text-slate-800">{{ $moment->user->username }}</span>
        </div>
    @endforeach

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-show="open" 
         class="fixed inset-0 z-[999] flex items-center justify-center bg-black/90 p-4" 
         @keydown.escape.window="open = false" 
         style="display: none;">
        
        <button @click="open = false" class="absolute top-6 right-6 text-white hover:text-slate-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="max-w-md w-full aspect-[9/16] relative">
            <img :src="activeImage" class="w-full h-full object-cover rounded-3xl shadow-2xl border border-white/10">
            
            <div class="absolute top-4 left-4 right-4 flex space-x-1">
                <div class="h-1 flex-1 bg-white/40 rounded-full overflow-hidden">
                    <div class="h-full bg-white w-full"></div>
                </div>
            </div>
        </div>
    </div>
</div>

FINE SEZIONE MOMENTI

        @foreach ($posts as $post)
            <div class="bg-white rounded-[2rem] shadow-[0_10px_30px_rgba(0,0,0,0.02)] mb-8 border border-slate-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/5">
                
                <!-- Header Post -->
                <div class="p-6 flex items-start justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('users.show', $post->user) }}" class="relative group">
                            <img src="{{ $post->user->getAvatarUrl() }}" class="w-12 h-12 rounded-2xl object-cover border-2 border-slate-50 shadow-sm transition group-hover:scale-105">
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-indigo-500 border-2 border-white rounded-full"></div>
                        </a>
                        <div class="flex flex-col ml-4">
                            <a href="{{ route('users.show', $post->user) }}" class="font-black text-slate-900 hover:text-indigo-600 transition">
                                {{ $post->user->username }}
                            </a>
                            <span class="text-slate-400 text-[10px] uppercase font-bold tracking-tight">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    @if(auth()->check() && auth()->id() === $post->user_id)
                        <form action="{{ route('post.destroy', $post) }}" method="POST" onsubmit="return confirm('Eliminare il post?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
                
                <!-- Contenuto Post -->
                <div class="px-6 pb-4">
                    <p class="text-slate-700 leading-relaxed text-[17px]">
                        {{ $post->body }}
                    </p>

                    @if($post->image)
                        <div class="mt-4 overflow-hidden rounded-3xl border border-slate-50">
                            <img src="{{ Storage::url($post->image) }}" class="w-full h-auto max-h-[500px] object-cover">
                        </div>
                    @endif
                </div>

                <!-- Interazioni -->
                <div class="px-6 py-4 flex items-center space-x-6 border-t border-slate-50">
                    <!-- Like -->
                    <form action="{{ route('post.like', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 group transition {{ auth()->check() && $post->isLikedBy(auth()->user()) ? 'text-red-500' : 'text-slate-400' }}">
                            <div class="p-2 rounded-xl group-hover:bg-red-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ auth()->check() && $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <span class="font-black text-sm">{{ $post->likes->count() }}</span>
                        </button>
                    </form>

                    <div class="flex items-center space-x-2 text-slate-400">
                            <div class="p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <span class="font-black text-sm">{{ $post->views_count ?? 0 }}</span>
                        </div>


                    <!-- Comment Counter -->
                    <div class="flex items-center space-x-2 text-slate-400">
                        <div class="p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <span class="font-black text-sm">{{ $post->comments->count() }}</span>
                    </div>
                </div>

                <!-- Area Commenti -->
                <div class="bg-slate-50/50 p-6 border-t border-slate-100">
                    <div class="space-y-4 mb-6">
                        @foreach($post->comments as $comment)
                            <div class="flex space-x-3 items-start">
                                <img src="{{ $comment->user->getAvatarUrl() }}" class="w-8 h-8 rounded-xl object-cover border border-white shadow-sm">
                                <div class="flex-1 bg-white p-4 rounded-2xl shadow-sm border border-slate-100 relative group/comment">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-black text-indigo-600">@ {{ $comment->user->username }}</span>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-slate-700">{{ $comment->body }}</p>

                                    @auth
                                        @if(auth()->id() === $comment->user_id)
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="absolute -right-2 -top-2 opacity-0 group-hover/comment:opacity-100 transition">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-white text-red-500 shadow-md p-1 rounded-full border border-red-50 hover:bg-red-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
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

                    @auth
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="flex items-center space-x-3">
                            @csrf
                            <div class="flex-1 relative">
                                <input type="text" name="body" placeholder="Scrivi un commento..." 
                                    class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition shadow-sm">
                                <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-indigo-600 hover:text-indigo-800 font-black text-xs uppercase tracking-widest">
                                    Invia
                                </button>
                            </div>
                        </form>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>

</body>
</html>