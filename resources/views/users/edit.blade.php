<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Profilo | Pulse</title>
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

    <div class="max-w-xl mx-auto mt-12 px-4 pb-20">
        <div class="bg-white/80 backdrop-blur-md p-8 rounded-[2.5rem] shadow-sm border border-white">
            <h2 class="text-3xl font-black mb-8 text-slate-900 tracking-tight">Modifica Profilo</h2>

            <form action="{{ route('users.update', $user->username) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="flex flex-col items-center gap-4 p-4 bg-slate-50/50 rounded-3xl border border-dashed border-slate-200">
                    <div class="relative">
                        <img id="avatar-preview" src="{{ $user->getAvatarUrl() }}" 
                             class="w-24 h-24 rounded-[2rem] object-cover shadow-lg border-4 border-white">
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-indigo-500 rounded-full border-2 border-white"></div>
                    </div>
                    
                    <div class="w-full">
                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Foto Profilo</label>
                        <input type="file" name="avatar" id="avatar-input" accept="image/*" 
                               class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-widest file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Bio (Raccontaci di te)</label>
                    <textarea name="bio" rows="3" maxlength="255"
                              class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all resize-none" 
                              placeholder="Scrivi qualcosa...">{{ $user->bio }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Città / Posizione</label>
                    <input type="text" name="location" value="{{ $user->location }}" 
                           class="w-full p-4 bg-slate-50 border border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all"
                           placeholder="Es: Milano, Italia">
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition shadow-lg shadow-slate-200">
                        Salva Modifiche
                    </button>
                    <a href="{{ route('users.show', $user->username) }}" class="px-6 py-4 text-slate-400 font-bold text-xs uppercase tracking-widest hover:text-slate-600 transition">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('avatar-input').onchange = evt => {
            const [file] = document.getElementById('avatar-input').files;
            if (file) {
                document.getElementById('avatar-preview').src = URL.createObjectURL(file);
            }
        }
    </script>
</body>
</html>