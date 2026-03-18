{{-- resources/views/gift/show.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjeta para {{ $gift->recipient_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes revealCard {
            from { opacity: 0; transform: translateY(24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1);    }
        }
        @keyframes revealItem {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0);    }
        }
        .reveal      { animation: revealCard 0.7s cubic-bezier(0.16,1,0.3,1) forwards; }
        .reveal-1    { opacity:0; animation: revealItem 0.5s ease 0.3s forwards; }
        .reveal-2    { opacity:0; animation: revealItem 0.5s ease 0.45s forwards; }
        .reveal-3    { opacity:0; animation: revealItem 0.5s ease 0.6s forwards; }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center" style="padding:24px 16px;">

    {{-- Fondo con gradiente radial sutil --}}
    <div class="fixed inset-0 pointer-events-none"
         style="background: radial-gradient(ellipse 70% 50% at 50% 0%, rgba(139,90,43,0.08) 0%, transparent 70%);"></div>

    <div class="relative w-full" style="max-width:480px;">

        {{-- ── TARJETA PRINCIPAL ── --}}
        @php $classes = $gift->giftCard->design_classes; @endphp
        <div class="reveal card overflow-hidden mb-4" style="min-height:calc(100vh - 160px);display:flex;flex-direction:column;">

            {{-- Franja de color del diseño elegido --}}
            <div class="h-1.5 w-full bg-gradient-to-r {{ $classes['bg'] }}"></div>

            <div class="p-7" style="flex:1;display:flex;flex-direction:column;justify-content:space-between;">

                {{-- Cabecera: plantilla + producto --}}
                <div class="flex items-center justify-between mb-7">
                    <span class="badge">{{ $gift->giftCard->title }}</span>
                    <span class="text-xs text-latte">{{ $gift->product->name }}</span>
                </div>

                {{-- Destinatario --}}
                <div class="mb-6">
                    <p class="text-xs font-semibold text-latte uppercase tracking-widest mb-1">Para</p>
                    <h1 class="font-display text-5xl text-espresso leading-tight">
                        {{ $gift->recipient_name }}
                    </h1>
                </div>

                {{-- Separador --}}
                <div class="flex items-center gap-3 mb-5">
                    <div class="h-px flex-1 bg-cream"></div>
                    <span class="text-latte/50 text-xs">✦</span>
                    <div class="h-px flex-1 bg-cream"></div>
                </div>

                {{-- Mensaje --}}
                <blockquote class="font-display text-xl italic leading-relaxed text-espresso/80 mb-8" style="flex:1;">
                    "{{ $gift->message }}"
                </blockquote>

                {{-- Footer: clave de acceso --}}
                <div class="flex items-center justify-between pt-4 border-t border-cream">
                    <p class="text-xs text-latte">Con amor ❤</p>
                    <div class="flex items-center gap-1.5 bg-foam rounded-lg px-3 py-1.5 border border-cream">
                        <svg class="w-3 h-3 text-latte" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        <span class="font-mono text-xs text-espresso/60 tracking-widest">{{ $gift->access_key }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── ACCIONES ── --}}
        <div class="space-y-2 reveal-1">
            <button onclick="shareCard()"
                    class="btn btn-primary w-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
                Compartir tarjeta
            </button>

            <a href="{{ route('gift.access') }}" class="btn btn-secondary w-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Ver otra tarjeta
            </a>
        </div>

        {{-- ── FOOTER ── --}}
        <p class="text-center text-xs text-latte/50 mt-6 reveal-2">
            Café Gift Cards · Hecho con amor ☕
        </p>

    </div>

    <script>
        async function shareCard() {
            const url  = window.location.href;
            const key  = '{{ $gift->access_key }}';
            const name = '{{ $gift->recipient_name }}';
            if (navigator.share) {
                await navigator.share({
                    title: `Una tarjeta para ${name} 🎁`,
                    text:  `Abre tu tarjeta con la clave: ${key}`,
                    url,
                });
            } else {
                await navigator.clipboard.writeText(url);
                alert('¡Enlace copiado al portapapeles!');
            }
        }
    </script>
</body>
</html>