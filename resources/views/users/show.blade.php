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
            toast.style.transition = 'opacity 0.5s ease';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    </script>
    @endif

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
                        <p class="mt-4 text-slate-600 leading-relaxed max-w-md">
                            {{ $user->bio }}
                        </p>
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
                            <div class="text-center">
                                <p class="text-xl font-black text-slate-900 leading-none">{{ $user->followers()->count() }}</p>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Followers</p>
                            </div>
                            <div class="text-center border-x border-slate-100 px-6">
                                <p class="text-xl font-black text-slate-900 leading-none">{{ $user->following()->count() }}</p>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Seguiti</p>
                            </div>
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
                    <div class="bg-white/80 backdrop-blur-md rounded-[2.5rem] shadow-sm border border-white overflow-hidden transition-all hover:shadow-md">
                        <div class="p-8">
                            <p class="text-slate-700 text-lg leading-relaxed">{{ $post->body }}</p>
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="mt-6 rounded-[2rem] w-full object-cover max-h-96 shadow-sm">
                            @endif
                            <div class="mt-4 text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                {{ $post->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="px-8 py-4 bg-slate-50/50 border-t border-white flex items-center space-x-6">
                            <form action="{{ route('post.like', $post) }}" method="POST">
                                @csrf
                                <button class="flex items-center space-x-2 group {{ auth()->user() && $post->isLikedBy(auth()->user()) ? 'text-red-500' : 'text-slate-400 hover:text-red-500' }} transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-active:scale-125 transition" fill="{{ auth()->user() && $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span class="font-black text-sm">{{ $post->likes()->count() }}</span>
                                </button>
                            </form>

                            <div class="flex items-center space-x-2 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span class="font-black text-sm">{{ $post->comments()->count() }}</span>
                            </div>

                            @auth
                            @if(auth()->id() === $user->id)
                                <form action="{{ route('post.destroy', $post) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo post?');" class="ml-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-300 hover:text-red-500 transition-colors group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-slate-50/50 rounded-[3rem] border border-dashed border-slate-200">
                        <p class="text-slate-400 font-medium italic text-lg">Nessun post ancora... un po' timido? 😶‍🌫️</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</body>
</html>