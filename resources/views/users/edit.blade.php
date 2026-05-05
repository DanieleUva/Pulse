<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Profilo | Pulse</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <x-navbar />

    <div class="max-w-xl mx-auto mt-10 px-4">
        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Modifica Profilo</h2>

            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Foto Profilo</label>
                    <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer border border-gray-200 rounded-lg p-2">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Bio (max 255 caratteri)</label>
                    <textarea name="bio" rows="3" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">{{ $user->bio }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Città / Posizione</label>
                    <input type="text" name="location" value="{{ $user->location }}" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('users.show', $user) }}" class="px-5 py-2 text-gray-600 bg-gray-100 rounded-full hover:bg-gray-200 font-semibold transition">Annulla</a>
                    <button type="submit" class="px-5 py-2 text-white bg-indigo-600 rounded-full hover:bg-indigo-700 font-semibold transition shadow-md">Salva Modifiche</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>