<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulse | {{ $user->name }}</title>
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

   @if(session('success'))
    <div id="toast" class="fixed top-24 left-1/2 -translate-x-1/2 z-50 animate-bounce">
        <div class="bg-slate-900 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3 border border-slate-700">
            <div class="bg-green-500 rounded-full p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="text-xs font-black uppercase tracking-widest">{{ session('success') }}</p>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if(toast) {
                toast.style.transition = 'opacity 0.5s ease';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>
@endif

<!-- Carica Alpine.js e Style SEMPRE (Fuori dall'if) -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    [x-cloak] { display: none !important; }
</style>

    <div class="max-w-4xl mx-auto mt-12 px-4 pb-20">
        
        <div class="bg-white/80 backdrop-blur-md rounded-[3rem] p-8 shadow-sm border border-white mb-10">
            <div class="flex flex-col md:flex-row items-center md:items-end justify-between gap-6">
                
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="relative">
                        <img src="{{ $user->getAvatarUrl() }}" 
                             class="w-32 h-32 rounded-[2.5rem] object-cover shadow-2xl border-4 border-white ring-1 ring-slate-100">
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-indigo-500 border-4 border-white rounded-2xl shadow-lg"></div>
                    </div>

                    <div class="text-center md:text-left">
                        <h1 class="text-4xl font-black text-slate-900 tracking-tight">{{ $user->name }}</h1>
                        <p class="text-indigo-600 font-bold text-lg">@ {{ $user->username }}</p>

                        @if($user->bio)
                            <p class="mt-4 text-slate-600 leading-relaxed max-w-md">{{ $user->bio }}</p>
                        @endif

                        @if($user->location)
                            <div class="flex items-center mt-3 text-slate-400 text-xs font-bold uppercase tracking-widest">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $user->location }}
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-center md:justify-start space-x-6 mt-4">
                            <a href="{{ route('users.followers', $user->username) }}" class="text-center group block transition active:scale-95">
                                <p class="text-xl font-black text-slate-900 leading-none group-hover:text-indigo-600 transition-colors">{{ $user->followers()->count() }}</p>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Followers</p>
                            </a>
                            
                            <a href="{{ route('users.following', $user->username) }}" class="text-center border-x border-slate-100 px-6 group block transition active:scale-95">
                                <p class="text-xl font-black text-slate-900 leading-none group-hover:text-indigo-600 transition-colors">{{ $user->following()->count() }}</p>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Seguiti</p>
                            </a>
                            
                            <div class="text-center">
                                <p class="text-xl font-black text-slate-900 leading-none">{{ $user->posts()->count() }}</p>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Post</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    @auth
                        @if(auth()->id() === $user->id)
                            <a href="{{ route('users.edit', $user->username) }}" class="bg-slate-900 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-slate-800 transition shadow-lg shadow-slate-200">
                             Modifica Profilo
                            </a>
                        @else
                            <a href="{{ route('chat.show', $user) }}" class="p-4 bg-indigo-50 text-indigo-600 rounded-2xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </a>

                            <form action="{{ route('user.follow', $user) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="px-10 py-4 rounded-2xl font-black text-sm uppercase tracking-widest transition-all duration-200 active:scale-95 shadow-lg
                                    {{ auth()->user()->isFollowing($user) 
                                        ? 'bg-slate-100 text-slate-500 hover:bg-red-50 hover:text-red-500 border border-slate-200' 
                                        : 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-indigo-200' }}">
                                    {{ auth()->user()->isFollowing($user) ? 'Seguito' : 'Segui' }}
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        @auth
            @if(auth()->id() === $user->id)
                <div class="max-w-2xl mx-auto mb-12">
                    <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] p-8 shadow-sm border border-white">
                        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="flex gap-4">
                                <img src="{{ auth()->user()->getAvatarUrl() }}" class="w-12 h-12 rounded-2xl object-cover shadow-sm">
                                <textarea name="body" rows="3" 
                                    class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all resize-none text-slate-700" 
                                    placeholder="Cosa stai pensando, {{ auth()->user()->name }}?"></textarea>
                            </div>
                            
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-50">
                                <input type="file" name="image" id="post-image" class="hidden" accept="image/*">
                                <label for="post-image" class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl cursor-pointer hover:bg-indigo-100 transition font-bold text-xs uppercase tracking-widest">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Foto
                                </label>
                                
                                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                                    Pubblica
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endauth

        <div class="max-w-2xl mx-auto">
            <h3 class="text-xl font-black text-slate-800 mb-6 flex items-center">
                <span class="w-8 h-1 bg-indigo-500 rounded-full mr-3"></span>
                Post pubblicati
            </h3>

            <div class="space-y-8">
                @forelse($user->posts as $post)
                <div id="post-{{ $post->id }}" class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-sm border border-white overflow-hidden transition-all hover:shadow-md">
                        <div class="p-8">
                            <p class="text-slate-700 text-lg leading-relaxed">{{ $post->body }}</p>
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="mt-6 rounded-[2rem] w-full object-cover max-h-96 shadow-sm">
                            @endif
                            <div class="mt-4 text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                {{ $post->created_at->diffForHumans() }}
                            </div>
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
                                <div class="px-8 py-4 bg-white border-t border-slate-100">
                                    <form action="{{ route('comments.store', $post) }}" method="POST" class="flex gap-4">
                                        @csrf
                                        <input type="text" name="body" placeholder="Scrivi un commento..." required
                                            class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition">
                                            Invia
                                        </button>
                                    </form>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div> @empty
                    <div class="text-center py-20 bg-slate-50/50 rounded-[3rem] border border-dashed border-slate-200">
                        <p class="text-slate-400 font-medium italic text-lg">Nessun post ancora... 😶‍🌫️</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <x-footer />
</body>
</html>