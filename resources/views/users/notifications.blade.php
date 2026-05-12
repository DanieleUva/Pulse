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
                        
                        @php
                            $user_id = $notification->data['user_id'] ?? ($notification->data['follower_id'] ?? null);
                            $user_name = $notification->data['user_name'] ?? ($notification->data['follower_name'] ?? 'Utente');
                            $username = $notification->data['username'] ?? ($notification->data['follower_username'] ?? $user_name);
                            // Se hai un modo per recuperare l'avatar dal DB o dal data
                            $avatar = $notification->data['user_avatar'] ?? ($notification->data['follower_avatar'] ?? '/default-avatar.png');
                        @endphp

                        <a href="{{ route('users.show', $username) }}">
                            <img src="{{ $avatar }}" 
                                 class="w-12 h-12 rounded-2xl object-cover border-2 border-slate-50 shadow-sm hover:border-indigo-400 transition">
                        </a>

                        <div>
                            <p class="text-slate-900 leading-tight">
                                <a href="{{ route('users.show', $username) }}" class="font-black hover:text-indigo-600 transition-colors">
                                    {{ $user_name }}
                                </a> 
                                
                                <span class="font-medium text-slate-500">
                                    @if($notification->type === 'follow')
                                        ha iniziato a seguirti
                                    @elseif($notification->type === 'like')
                                        ha messo like al tuo post
                                    @elseif($notification->type === 'comment')
                                        ha commentato: "{{ Str::limit($notification->data['comment_body'] ?? 'un tuo post', 30) }}"
                                    @else
                                        {{ $notification->data['message'] ?? 'nuova interazione' }}
                                    @endif
                                </span>
                            </p>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <div class="hidden sm:block">
                        @if($notification->type === 'follow')
                            <svg class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        @elseif($notification->type === 'like')
                            <svg class="h-6 w-6 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        @elseif($notification->type === 'comment')
                            <svg class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        @endif
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