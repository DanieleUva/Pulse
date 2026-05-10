<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unisciti a Pulse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-200 antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center px-6 py-12">
        
        <div class="mb-8 flex items-center space-x-2">
            <span class="text-4xl font-black tracking-tighter text-white">PULSE</span>
            <div class="w-3 h-3 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_15px_#6366f1]"></div>
        </div>

        <div class="w-full max-w-md bg-slate-900 border border-slate-800 p-8 rounded-[2.5rem] shadow-2xl">
            <h2 class="text-2xl font-bold text-white mb-2 text-center">Crea il tuo account</h2>
            <p class="text-slate-500 text-center mb-8 text-sm font-medium">Entra a far parte della community.</p>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-900/30 border border-red-500/50 rounded-2xl text-red-400 text-xs">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Nome Completo</label>
                    <input type="text" name="name" :value="old('name')" required autofocus 
                        class="w-full bg-slate-950 border border-slate-800 text-white rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all mt-1 placeholder-slate-700"
                        placeholder="es. Mario Rossi">
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Username</label>
                    <input type="text" name="username" :value="old('username')" required 
                        class="w-full bg-slate-950 border border-slate-800 text-white rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all mt-1 placeholder-slate-700"
                        placeholder="es. mario_99">
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Email</label>
                    <input type="email" name="email" :value="old('email')" required 
                        class="w-full bg-slate-950 border border-slate-800 text-white rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all mt-1 placeholder-slate-700"
                        placeholder="mario@esempio.com">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Password</label>
                        <input type="password" name="password" required 
                            class="w-full bg-slate-950 border border-slate-800 text-white rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all mt-1">
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-2">Conferma</label>
                        <input type="password" name="password_confirmation" required 
                            class="w-full bg-slate-950 border border-slate-800 text-white rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all mt-1">
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-indigo-900/20 transition-all transform hover:scale-[1.02] mt-4">
                    REGISTRATI ORA
                </button>
            </form>

            <div class="mt-8 text-center border-t border-slate-800 pt-6">
                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-500 hover:text-indigo-400 transition">
                    Hai già un profilo? <span class="text-indigo-500">Accedi</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>