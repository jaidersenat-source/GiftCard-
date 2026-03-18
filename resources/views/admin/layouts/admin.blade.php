{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin · @yield('title', 'Panel') · Café Gift Cards</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Sidebar activo */
        .nav-active {
            background: var(--cream);
            color: var(--caramel);
            font-weight: 600;
        }
        .nav-active .nav-icon {
            background: var(--caramel);
            color: #fff;
        }
        .nav-item:not(.nav-active) .nav-icon {
            background: var(--foam);
            color: var(--latte);
        }
        .nav-item:not(.nav-active):hover .nav-icon {
            background: var(--cream);
            color: var(--caramel);
        }
    </style>
</head>
<body class="min-h-screen" x-data="{ sidebarOpen: false }">

{{-- ══════════════════════════════════════════════════
     TOPBAR — visible en móvil y desktop
══════════════════════════════════════════════════ --}}
<header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-cream
               flex items-center justify-between px-4 h-14">

    {{-- Izquierda: hamburger + logo --}}
    <div class="flex items-center gap-3">
        <button @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden w-8 h-8 rounded-lg flex items-center justify-center
                       text-latte hover:text-caramel hover:bg-cream transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <span class="font-display text-lg text-caramel">🎁 GiftCard</span>
        <span class="hidden sm:inline text-xs text-latte border-l border-cream pl-3">Panel Admin</span>
    </div>

    {{-- Derecha: usuario + logout --}}
    <div class="flex items-center gap-3">
        <div class="hidden sm:flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-cream flex items-center justify-center">
                <svg class="w-4 h-4 text-caramel" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <span class="text-xs font-medium text-espresso">{{ auth()->user()->name ?? 'Admin' }}</span>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex items-center gap-1.5 text-xs text-latte hover:text-brand-red transition-colors px-2 py-1 rounded-lg hover:bg-brand-red-lt">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Salir
            </button>
        </form>
    </div>
</header>


<div class="flex min-h-[calc(100vh-56px)]">

    {{-- ══════════════════════════════════════════════════
         SIDEBAR
    ══════════════════════════════════════════════════ --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 top-14 z-30 w-56
                  bg-white border-r border-cream
                  transform transition-transform duration-300 ease-out
                  lg:translate-x-0 lg:static lg:flex-shrink-0">

        <nav class="p-3 space-y-0.5">

            {{-- Sección principal --}}
            <p class="text-xs font-semibold text-latte uppercase tracking-widest px-3 pt-3 pb-2">
                Gestión
            </p>

            @php
            $navItems = [
                [
                    'route' => 'admin.products.index',
                    'label' => 'Productos',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
                ],
                [
                    'route' => 'admin.gift-cards.index',
                    'label' => 'Plantillas',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>',
                ],
                [
                    'route' => 'admin.gifts.index',
                    'label' => 'Tarjetas creadas',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>',
                ],
            ];
            @endphp

            @foreach($navItems as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <a href="{{ route($item['route']) }}"
               class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
                      {{ $active ? 'nav-active' : 'text-latte hover:text-espresso hover:bg-foam' }}">
                <span class="nav-icon w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $item['icon'] !!}
                    </svg>
                </span>
                {{ $item['label'] }}
            </a>
            @endforeach

            {{-- Separador --}}
            <div class="h-px bg-cream mx-3 my-3"></div>

            {{-- Ver sitio --}}
            <a href="{{ route('landing') }}" target="_blank"
               class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-latte hover:text-espresso hover:bg-foam transition-all">
                <span class="nav-icon w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </span>
                Ver sitio
            </a>
        </nav>
    </aside>

    {{-- Overlay sidebar móvil --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 top-14 z-20 bg-espresso/40 backdrop-blur-sm lg:hidden"></div>


    {{-- ══════════════════════════════════════════════════
         CONTENIDO PRINCIPAL
    ══════════════════════════════════════════════════ --}}
    <main class="flex-1 min-w-0 p-4 lg:p-8 bg-foam">

        {{-- Flash success --}}
        @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-brand-green-lt border border-brand-green/20
                    text-brand-green rounded-xl px-4 py-3 text-sm fade-up">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Flash error --}}
        @if(session('error'))
        <div class="mb-6 flex items-center gap-3 bg-brand-red-lt border border-brand-red/20
                    text-brand-red rounded-xl px-4 py-3 text-sm fade-up">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>