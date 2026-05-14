<footer class="relative left-[50%] right-[50%] -ml-[50vw] -mr-[50vw] w-[100vw] bg-[#0B1120] border-t border-gray-800 pt-16 pb-8 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12 text-left">
            
            <!-- Colonna 1: Brand -->
            <div class="col-span-1 md:col-span-1">
                <span class="text-2xl font-bold text-white tracking-tighter">
                    PULSE<span class="text-indigo-500">.</span>
                </span>
                <p class="mt-4 text-gray-400 text-sm leading-relaxed">
                    La piattaforma social per connettere idee e persone. <br>
                    Costruita per la velocità e la sicurezza.
                </p>
            </div>

            <!-- Colonna 2: Link Rapidi -->
            <div>
                <h3 class="text-white font-semibold mb-4 text-xs uppercase tracking-widest">Piattaforma</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-400 transition-colors">Home Feed</a></li>
                    <li><a href="{{ route('explore') }}" class="hover:text-indigo-400 transition-colors">Esplora</a></li>
                    <li><a href="{{ route('chat.index') }}" class="hover:text-indigo-400 transition-colors">Messaggi</a></li>
                </ul>
            </div>

            <!-- Colonna 3: Supporto & Legale -->
            <div>
                <h3 class="text-white font-semibold mb-4 text-xs uppercase tracking-widest">Legale</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Termini di Servizio</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition-colors">Linee Guida</a></li>
                </ul>
            </div>

            <!-- Colonna 4: Tech Stack -->
            <div>
                <h3 class="text-white font-semibold mb-4 text-xs uppercase tracking-widest">Sviluppato con</h3>
                <div class="flex flex-wrap gap-2">
                    <span class="px-2 py-1 bg-slate-800/50 text-indigo-300 text-[10px] font-medium rounded border border-indigo-500/30">Laravel 11</span>
                    <span class="px-2 py-1 bg-slate-800/50 text-sky-300 text-[10px] font-medium rounded border border-sky-500/30">Tailwind CSS</span>
                    <span class="px-2 py-1 bg-slate-800/50 text-emerald-300 text-[10px] font-medium rounded border border-emerald-500/30">Alpine.js</span>
                    <span class="px-2 py-1 bg-slate-800/50 text-amber-300 text-[10px] font-medium rounded border border-amber-500/30">MySQL</span>
                </div>
            </div>
        </div>

        <!-- Barra inferiore -->
        <div class="border-t border-gray-800/60 pt-8 flex flex-col md:flex-row justify-between items-center text-[11px] text-gray-500 tracking-wide uppercase">
            <p>&copy; {{ date('Y') }} <span class="text-gray-300 font-bold">Pulse Network</span>. Tutti i diritti riservati.</p>
            <p class="mt-2 md:mt-0 italic hover:text-white transition-colors cursor-default text-right">
                Designed & Developed by <span class="text-indigo-400 not-italic font-semibold">Daniele</span>
            </p>
        </div>
    </div>
</footer>