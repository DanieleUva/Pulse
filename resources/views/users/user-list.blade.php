<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulse | {{ $title }}</title>
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

    <div class="max-w-2xl mx-auto mt-12 px-4 pb-20">
        
        <h2 class="text-3xl font-black text-slate-800 mb-8 uppercase tracking-tighter flex items-center">
            <span class="w-8 h-1 bg-indigo-500 rounded-full mr-3"></span>
            {{ $title }}
        </h2>

        <div class="space-y-4">
            @forelse($users as $u)
                <div class="bg-white/80 backdrop-blur-md p-6 rounded-[2.5rem] shadow-sm border border-white flex items-center justify-between transition-all hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <img src="{{ $u->getAvatarUrl() }}" 
                             class="w-14 h-14 rounded-2xl object-cover shadow-sm border-2 border-white ring-1 ring-slate-100">
                        <div>
                            <p class="font-black text-slate-900 text-lg leading-none">{{ $u->name }}</p>
                            <p class="text-indigo-600 font-bold text-sm mt-1">@ {{ $u->username }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('users.show', $u->username) }}" 
                       class="bg-slate-900 text-white px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition shadow-lg shadow-slate-200 active:scale-95">
                        Profilo
                    </a>
                </div>
            @empty
                <div class="text-center py-20 bg-slate-100/50 rounded-[3rem] border border-dashed border-slate-300">
                    <p class="text-slate-400 font-medium italic text-lg">Nessun utente trovato qui... 😶‍🌫️</p>
                </div>
            @endforelse
        </div>

        @if($users->hasPages())
            <div class="mt-10 bg-white/50 p-4 rounded-2xl shadow-inner">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</body>
</html>