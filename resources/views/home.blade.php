<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Pulse</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-gray-100">

    <x-navbar />

    <div class="max-w-2xl mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Benvenuto su Pulse! 🚀</h1>

        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <form action="/post" method="POST">
                @csrf
                <textarea name="body" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" rows="3" placeholder="A cosa stai pensando?" required></textarea>
                <button type="submit" class="mt-3 bg-indigo-600 text-white px-6 py-2 rounded-full font-bold hover:bg-indigo-700 transition">Pubblica Post</button>
            </form>
        </div>

        <h3 class="text-xl font-semibold mb-4">Tutti i Post:</h3>
            @foreach ($posts as $post)
                <div class="post-card">
                    <div class="flex items-center mb-2">
                        <span class="font-bold text-indigo-600">@ {{ $post->user->username }}</span>
                        <span class="text-gray-400 text-xs ml-2">• {{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <p class="post-body">{{ $post->body }}</p>
                </div>
            @endforeach
    </div>

</body>
</html>