<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifiche | Pulse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">
    <x-navbar />

    <div class="max-w-2xl mx-auto mt-12 px-4 pb-20">
        <div class="mb-10">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Notifiche</h1>
            <p class="text-slate-500 font-medium">Resta aggiornato sulle tue interazioni.</p>
        </div>

        <div class="space-y-4">
            @forelse($notifications as $notification)
                <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
                    <div class="flex items-center space-x-4">
                        
                        <a href="{{ route('users.show', $notification->data['follower_username'] ?? $notification->data['follower_name']) }}">
                            <img src="{{ $notification->data['follower_avatar'] ?? '/default-avatar.png' }}" 
                                 class="w-12 h-12 rounded-2xl object-cover border-2 border-slate-50 shadow-sm hover:border-indigo-400 transition">
                        </a>

                        <div>
                            <p class="text-slate-900">
                                <a href="{{ route('users.show', $notification->data['follower_username'] ?? $notification->data['follower_name']) }}" 
                                   class="font-black hover:text-indigo-600 transition-colors">
                                    {{ $notification->data['follower_name'] }}
                                </a> 
                                <span class="font-medium text-slate-500">{{ $notification->data['message'] }}</span>
                            </p>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <div class="hidden sm:block text-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-slate-200">
                    <p class="text-slate-400 font-bold text-lg italic">Nessuna notifica per ora. 😴</p>
                    <a href="{{ route('explore') }}" class="mt-4 inline-block text-indigo-600 font-black text-sm uppercase tracking-wider hover:underline">
                        Trova persone da seguire
                    </a>
                </div>
            @endforelse

            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</body>
</html>