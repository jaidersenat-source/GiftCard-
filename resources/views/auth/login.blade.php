{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Admin · Café Gift Cards</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-sm fade-up">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-card bg-roast">
            <svg class="w-8 h-8 text-latte" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h1 class="font-display text-2xl text-espresso">Panel Admin</h1>
        <p class="text-latte text-sm mt-1">Café Gift Cards</p>
    </div>

    {{-- Errores --}}
    @if($errors->any())
    <div class="mb-4 bg-brand-red-lt border border-brand-red/20 rounded-xl px-4 py-3 fade-up">
        @foreach($errors->all() as $error)
            <p class="text-brand-red text-sm">{{ $error }}</p>
        @endforeach
    </div>
    @endif

    {{-- Formulario --}}
    <div class="card p-6">
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1.5">
                    Correo electrónico
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                       autofocus required
                       class="input">
            </div>

            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1.5">
                    Contraseña
                </label>
                <input type="password" name="password" required
                       class="input">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember"
                       class="w-4 h-4 rounded accent-caramel">
                <label for="remember" class="text-xs text-latte">
                    Mantener sesión iniciada
                </label>
            </div>

            <button type="submit"
                    class="btn btn-primary w-full mt-2">
                Ingresar al panel
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </form>
    </div>

    {{-- Volver --}}
    <div class="text-center mt-6">
        <a href="{{ route('landing') }}"
           class="inline-flex items-center gap-1.5 text-xs text-latte hover:text-caramel transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver al inicio
        </a>
    </div>

</div>

</body>
</html>