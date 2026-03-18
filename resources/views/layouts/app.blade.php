<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GiftCard QR')</title>
    <meta name="description" content="Tarjetas de regalo digitales personalizadas">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen" style="background-color: var(--cream);">

    {{-- HEADER --}}
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/70 border-b border-stone-200/50 px-4 py-3">
        <div class="max-w-lg mx-auto flex items-center justify-between">
            <a href="{{ route('landing') }}" class="font-display text-xl font-bold tracking-tight" style="color: var(--gold);">
                🎁 GiftCard
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('gift.access') }}"
                   class="text-xs font-medium px-3 py-1.5 rounded-full bg-stone-100 text-stone-600 hover:bg-stone-200 transition">
                    Ver tarjeta
                </a>
                <a href="{{ route('login') }}"
                   class="text-xs font-semibold px-3 py-1.5 rounded-full text-white transition"
                   style="background:linear-gradient(135deg,#C9A84C,#E8C97A);color:#1A1208;">
                    Admin
                </a>
            </div>
        </div>
    </header>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         class="max-w-lg mx-auto mt-4 px-4">
        <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl px-4 py-3 text-sm">
            <span>✅</span> {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-lg mx-auto mt-4 px-4">
        <div class="flex items-center gap-2 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl px-4 py-3 text-sm">
            <span>⚠️</span> {{ session('error') }}
        </div>
    </div>
    @endif

    {{-- CONTENIDO --}}
    <main class="max-w-lg mx-auto px-4 py-6">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="text-center text-xs text-stone-400 py-8">
        Hecho con ❤️ · GiftCard QR
    </footer>

</body>
</html>