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
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes revealItem {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .reveal   { animation: revealCard 0.7s cubic-bezier(0.16,1,0.3,1) forwards; }
        .reveal-1 { opacity:0; animation: revealItem 0.5s ease 0.3s forwards; }
        .reveal-2 { opacity:0; animation: revealItem 0.5s ease 0.45s forwards; }

        /* ── Tarjeta con imagen de fondo ── */
        .gift-card-bg {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
        }
        .gift-card-bg .card-bg-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        /* Overlay oscuro para que el texto sea legible */
        .gift-card-bg .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                160deg,
                rgba(0,0,0,0.45) 0%,
                rgba(0,0,0,0.25) 40%,
                rgba(0,0,0,0.60) 100%
            );
        }
        .gift-card-bg .card-content {
            position: relative;
            z-index: 10;
        }

        /* Textos sobre imagen */
        .on-img-label   { color: rgba(255,255,255,0.65); font-size: 0.65rem; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; }
        .on-img-name    { color: #ffffff; font-size: clamp(2.8rem, 12vw, 3.5rem); line-height: 1.05; }
        .on-img-message { color: rgba(255,255,255,0.88); font-size: 1.15rem; font-style: italic; line-height: 1.6; }
        .on-img-muted   { color: rgba(255,255,255,0.55); font-size: 0.75rem; }

        /* Badge de categoría sobre imagen */
        .cat-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.25);
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        /* Clave de acceso sobre imagen */
        .access-key-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.8);
            font-family: monospace;
            font-size: 0.8rem;
            letter-spacing: 0.15em;
        }

        /* Separador sutil */
        .divider {
            width: 100%;
            height: 1px;
            background: rgba(255,255,255,0.18);
            margin: 1.5rem 0;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center"
      style="padding: 24px 16px; background: #f5f0eb;">

    <div class="relative w-full reveal" style="max-width: 420px;">

        {{-- ══ TARJETA PRINCIPAL ══ --}}
        @php $classes = $gift->giftCard->design_classes; @endphp

        @if($gift->giftCard->image_path)
        {{-- ── Versión con imagen de fondo ── --}}
        <div class="gift-card-bg" style="min-height: 580px; display: flex; flex-direction: column; justify-content: space-between;">

            {{-- Imagen de fondo --}}
            <img src="{{ $gift->giftCard->image_url }}"
                 alt="{{ $gift->giftCard->title }}"
                 class="card-bg-img">

            {{-- Overlay de legibilidad --}}
            <div class="card-overlay"></div>

            {{-- Contenido encima --}}
            <div class="card-content" style="padding: 28px 28px 32px; display: flex; flex-direction: column; min-height: 580px; justify-content: space-between;">

                {{-- Top: plantilla + categoría --}}
                <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                    <span class="cat-badge">
                        {{ $gift->giftCard->category ?? $gift->giftCard->title }}
                    </span>
                    <span class="on-img-muted" style="margin-top: 6px;">
                        {{ $gift->product->name }}
                    </span>
                </div>

                {{-- Centro: destinatario + mensaje --}}
                <div>
                    <p class="on-img-label" style="margin-bottom: 8px;">Para</p>
                    <h1 class="on-img-name font-display" style="margin: 0 0 24px;">
                        {{ $gift->recipient_name }}
                    </h1>

                    <div class="divider"></div>

                    <blockquote class="on-img-message font-display" style="margin: 0;">
                        "{{ $gift->message }}"
                    </blockquote>
                </div>

                {{-- Bottom: amor + clave --}}
                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 24px;">
                    <span class="on-img-muted">Con amor ❤</span>
                    <div class="access-key-pill">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        {{ $gift->access_key }}
                    </div>
                </div>
            </div>
        </div>

        @else
        {{-- ── Versión sin imagen (fallback color) ── --}}
        <div class="card overflow-hidden" style="min-height: 520px; display: flex; flex-direction: column;">
            <div class="h-1.5 w-full bg-gradient-to-r {{ $classes['bg'] }}"></div>
            <div class="p-7" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div class="flex items-center justify-between mb-7">
                    <span class="badge">{{ $gift->giftCard->title }}</span>
                    <span class="text-xs text-latte">{{ $gift->product->name }}</span>
                </div>
                <div class="mb-6">
                    <p class="text-xs font-semibold text-latte uppercase tracking-widest mb-1">Para</p>
                    <h1 class="font-display text-5xl text-espresso leading-tight">{{ $gift->recipient_name }}</h1>
                </div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="h-px flex-1 bg-cream"></div>
                    <span class="text-latte/50 text-xs">✦</span>
                    <div class="h-px flex-1 bg-cream"></div>
                </div>
                <blockquote class="font-display text-xl italic leading-relaxed text-espresso/80 mb-8" style="flex:1;">
                    "{{ $gift->message }}"
                </blockquote>
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
        @endif

        {{-- ══ ACCIONES ══ --}}
        <div class="space-y-2 reveal-1" style="margin-top: 16px;">
            <button onclick="shareCard()" class="btn btn-primary w-full">
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

        <p class="text-center reveal-2" style="font-size: 0.7rem; color: rgba(0,0,0,0.35); margin-top: 20px;">
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
                alert('¡Enlace copiado!');
            }
        }
    </script>
</body>
</html>