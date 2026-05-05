<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo di {{ $user->name }} | Pulse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-gray-100 font-sans antialiased">

    <x-navbar />

    <div class="max-w-2xl mx-auto mt-10 px-4">
        
        <!-- Intestazione Profilo -->
<div class="bg-white p-8 rounded-xl shadow-sm mb-8 border border-gray-200 text-center relative">
    
    <!-- Pulsante Modifica (Visibile solo al proprietario) -->
    @auth
        @if(auth()->id() === $user->id)
            <a href="{{ route('users.edit', $user) }}" class="absolute top-4 right-4 text-sm font-semibold text-indigo-600 bg-indigo-50 px-4 py-2 rounded-full hover:bg-indigo-100 transition">
                Modifica Profilo
            </a>
        @endif
    @endauth

    <!-- Avatar -->
    @if($user->avatar)
        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar di {{ $user->name }}" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-4 border-indigo-50 shadow-sm">
    @else
        <div class="w-24 h-24 bg-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-4xl shadow-inner mx-auto mb-4 uppercase">
            {{ substr($user->name, 0, 1) }}
        </div>
    @endif

    <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
    <p class="text-gray-500 mt-1">@ {{ $user->username }}</p>
    
    <!-- Bio e Location -->
    @if($user->bio)
        <p class="mt-4 text-gray-700 max-w-md mx-auto italic">"{{ $user->bio }}"</p>
    @endif

    @if($user->location)
        <p class="mt-2 text-sm text-gray-400 font-semibold flex items-center justify-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {{ $user->location }}
        </p>
    @endif

    <div class="mt-6 flex justify-center space-x-6 text-sm text-gray-600 border-t border-gray-100 pt-4">
        <p><span class="font-bold text-indigo-600 text-lg">{{ $posts->count() }}</span> Post</p>
        <p class="mt-0.5">Iscritto dal <span class="font-bold">{{ $user->created_at->format('M Y') }}</span></p>
    </div>
</div>
        
        <!-- Ciclo dei Post dell'utente -->
        @if($posts->count() > 0)
            @foreach ($posts as $post)
                <div class="bg-white p-5 rounded-xl shadow-sm mb-5 border border-gray-100 transition hover:shadow-md">
                    
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-11 h-11 bg-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-inner mr-3 uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center">
                                    <span class="font-bold text-gray-900">@ {{ $user->username }}</span>
                                    <span class="text-gray-400 text-xs ml-2">• {{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-gray-800 leading-relaxed {{ $post->image ? 'mb-4' : '' }}">
                        {{ $post->body }}
                    </p>

                    @if($post->image)
                        <div class="mt-3 overflow-hidden rounded-2xl border border-gray-100">
                            <img src="{{ Storage::url($post->image) }}" class="w-full h-auto object-cover transition hover:scale-[1.02] duration-300" alt="Immagine post">
                        </div>
                    @endif

                </div>
            @endforeach
        @else
            <p class="text-center text-gray-500 italic">Questo utente non ha ancora pubblicato nulla.</p>
        @endif

    </div>
</body>
</html>