<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accedi | Pulse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950">
    <div class="min-h-screen flex flex-col justify-center items-center px-6">
        
        <div class="mb-8 flex items-center space-x-2">
            <span class="text-4xl font-black tracking-tighter text-white">PULSE</span>
            <div class="w-3 h-3 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_15px_#6366f1]"></div>
        </div>

        <div class="w-full max-w-md bg-slate-900 border border-slate-800 p-8 rounded-[2.5rem] shadow-2xl">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">Bentornato</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-900/30 border border-red-500/50 rounded-2xl text-red-400 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="text-xs font-black uppercase tracking-widest text-slate-500 ml-2">Email</label>
                    <input type="email" name="email" :value="old('email')" required autofocus 
                        class="w-full bg-slate-950 border border-slate-800 text-white rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all mt-1">
                </div>

                <div>
                    <label class="text-xs font-black uppercase tracking-widest text-slate-500 ml-2">Password</label>
                    <input type="password" name="password" required 
                        class="w-full bg-slate-950 border border-slate-800 text-white rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all mt-1">
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-indigo-900/20 transition-all transform hover:scale-[1.02]">
                    ACCEDI
                </button>
            </form>

            <div class="mt-8 text-center border-t border-slate-800 pt-6">
                <a href="{{ route('register') }}" class="text-sm font-bold text-slate-500 hover:text-indigo-400 transition">
                    Non hai un account? <span class="text-indigo-500">Unisciti ora</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>