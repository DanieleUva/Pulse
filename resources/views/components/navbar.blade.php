<nav class="bg-indigo-600 p-4 shadow-lg w-full">
    <div class="max-w-4xl mx-auto flex justify-between items-center text-white">
        <a href="/" class="text-2xl font-bold tracking-wider">PULSE</a>
        <div class="space-x-4 flex items-center">
            @auth
                <span class="font-medium">Ciao, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 px-3 py-1 rounded hover:bg-red-600 transition">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:underline font-medium">Login</a>
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-4 py-2 rounded font-bold hover:bg-gray-100 transition">Registrati</a>
            @endauth
        </div>
    </div>
</nav>