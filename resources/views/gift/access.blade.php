<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver mi tarjeta · GiftCard</title>
    <link rel="icon" type="image/png" href="/img/logo.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="page-wrapper">

    <!-- ══ PANEL IZQUIERDO ══ -->
    <div class="panel-left" style="min-height: 38vh;">
        <div class="ring-deco"></div>
        <div class="ring-deco-2"></div>

        <!-- Etiqueta que indica qué perspectiva se muestra -->
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.5rem;align-self:flex-start;padding-left:0.25rem;">
            <span id="label-receiver" style="font-size:0.65rem;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.7);transition:color 0.4s;">👁 Para quien recibe</span>
            <span style="color:rgba(255,255,255,0.15);font-size:0.65rem;">·</span>
            <span id="label-creator" style="font-size:0.65rem;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.25);transition:color 0.4s;">✏️ Para quien crea</span>
        </div>

        <!-- Tarjeta decorativa -->
        <div class="hero-card" style="transition:opacity 0.3s ease,transform 0.3s ease;">
            <div class="hero-card-logo">
                <div class="card-dot"></div>
                <span id="card-header-text">Tu tarjeta te espera</span>
            </div>
            <p class="hero-card-to">Para</p>
            <p class="hero-card-name" id="card-name">¿Para quién es? 🎁</p>
            <p class="hero-card-msg" id="card-msg">"Ingresa tu palabra clave para descubrir el mensaje que alguien especial te dejó."</p>
            <div class="hero-card-footer">

                <!-- Footer: receptor -->
                <div id="footer-receiver" style="display:flex;align-items:center;justify-content:space-between;width:100%;">
                    <div class="hero-card-key">
                        <span>Clave:</span>
                        <strong>••••••••</strong>
                    </div>
                    <div class="hero-card-beans">
                        <div class="bean"></div>
                        <div class="bean"></div>
                        <div class="bean"></div>
                    </div>
                </div>

                <!-- Footer: creador (código resaltado) -->
                <div id="footer-creator" style="display:none;flex-direction:column;gap:0.35rem;width:100%;">
                    <span style="font-size:0.6rem;text-transform:uppercase;letter-spacing:0.12em;color:rgba(201,168,76,0.8);display:flex;align-items:center;gap:0.35rem;">
                        <span style="display:inline-block;width:5px;height:5px;border-radius:50%;background:#c9a84c;animation:pulse-dot 2s ease-in-out infinite;flex-shrink:0;"></span>
                        Código de acceso
                    </span>
                    <div style="display:flex;align-items:center;gap:0.4rem;">
                        @if($uniqueCode ?? null)
                            @foreach(explode('-', $uniqueCode) as $part)
                            <span style="background:rgba(201,168,76,0.15);border:1.5px solid rgba(201,168,76,0.5);border-radius:8px;padding:0.35rem 0.65rem;font-family:monospace;font-size:1rem;font-weight:800;color:#c9a84c;letter-spacing:0.1em;text-shadow:0 0 10px rgba(201,168,76,0.25);">{{ $part }}</span>
                            @if(!$loop->last)<span style="color:rgba(201,168,76,0.4);font-size:0.9rem;">—</span>@endif
                            @endforeach
                        @else
                            <span style="background:rgba(201,168,76,0.15);border:1.5px solid rgba(201,168,76,0.5);border-radius:8px;padding:0.35rem 0.65rem;font-family:monospace;font-size:1rem;font-weight:800;color:#c9a84c;letter-spacing:0.1em;">6A9</span>
                            <span style="color:rgba(201,168,76,0.4);font-size:0.9rem;">—</span>
                            <span style="background:rgba(201,168,76,0.15);border:1.5px solid rgba(201,168,76,0.5);border-radius:8px;padding:0.35rem 0.65rem;font-family:monospace;font-size:1rem;font-weight:800;color:#c9a84c;letter-spacing:0.1em;">5A5</span>
                        @endif
                        <span style="font-size:0.62rem;color:rgba(201,168,76,0.5);margin-left:0.3rem;">← úsalo abajo</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Texto del panel -->
        <div class="panel-left-text">
            <h2 class="panel-tagline">
                <span id="tagline-text">Un mensaje<br><em>guardado para ti</em></span>
            </h2>
            <p class="panel-sub" id="panel-sub-text">
                Alguien creó una tarjeta especial con tu nombre. Accede con tu palabra clave secreta.
            </p>
        </div>
    </div>

    <!-- ══ PANEL DERECHO — FORMULARIO ══ -->
    <div class="panel-right" style="justify-content: center;">

        <!-- Cabecera de navegación -->
        <div style="position:absolute;top:1.25rem;left:1.25rem;right:1.25rem;display:flex;align-items:center;justify-content:space-between;z-index:10;" class="hidden-mobile-nav">
            <a href="{{ route('landing') }}" class="footer-admin" style="font-size:0.8rem;gap:0.4rem;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;height:16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Inicio
            </a>
            <a href="{{ route('login') }}" class="footer-admin" style="font-size:0.75rem;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:13px;height:13px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Admin
            </a>
        </div>

        <div style="width:100%;max-width:420px;margin:0 auto;">

            <!-- Badge -->
            <div class="badge fade-up" style="margin-bottom:1.8rem;">
                @if($uniqueCode ?? null)
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Crear tarjeta de regalo
                @else
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Acceder a mi tarjeta
                @endif
            </div>

            <!-- Título -->
            <h1 class="section-heading fade-up d100" style="margin-bottom:0.5rem;">
                @if($uniqueCode ?? null)
                    Crea tu<br><span>tarjeta de regalo</span>
                @else
                    Ver mi<br><span>tarjeta de regalo</span>
                @endif
            </h1>

            @if($uniqueCode ?? null)
            <p class="section-sub fade-up d200" style="margin-bottom:2rem;">
                Ingresa el código que ves en la tarjeta para comenzar.
            </p>
            @else
            <p class="section-sub fade-up d200" style="margin-bottom:2rem;">
                Ingresa la palabra clave para ver tu tarjeta.
            </p>
            @endif

            <!-- Error -->
            @error('access_key')
            <div class="fade-up d200" style="background:#fff1f2;border:1px solid #fecdd3;border-radius:14px;padding:0.85rem 1.1rem;margin-bottom:1.25rem;color:#be123c;font-size:0.82rem;display:flex;align-items:center;gap:0.6rem;">
                ⚠️ {{ $message }}
            </div>
            @enderror

            <!-- Formulario -->
            <form method="POST" action="{{ route('gift.access.submit') }}" class="fade-up d300">
                @csrf

                <div style="position:relative;margin-bottom:1rem;">
                    <div style="position:absolute;left:1.1rem;top:50%;transform:translateY(-50%);pointer-events:none;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px;color:var(--latte);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <input type="text"
                           name="access_key"
                           value="{{ old('access_key') }}"
                           placeholder="{{ ($uniqueCode ?? null) ? 'Escribe el código de arriba' : 'Tu palabra clave secreta' }}"
                           autofocus
                           autocomplete="off"
                           style="width:100%;padding:1rem 1rem 1rem 3rem;border-radius:14px;border:1.5px solid var(--cream);background:#fff;font-family:var(--font-body);font-size:0.95rem;color:var(--espresso);outline:none;transition:border-color 0.2s,box-shadow 0.2s;text-transform:uppercase;letter-spacing:0.12em;"
                           onfocus="this.style.borderColor='var(--caramel)';this.style.boxShadow='0 0 0 3px rgba(139,90,43,0.12)';"
                           onblur="this.style.borderColor='var(--cream)';this.style.boxShadow='none';">
                </div>

                <button type="submit"
                        style="width:100%;padding:1rem;border-radius:14px;border:none;background:linear-gradient(135deg,var(--espresso),var(--roast));color:#fff;font-family:var(--font-body);font-size:0.92rem;font-weight:600;cursor:pointer;transition:all 0.2s;box-shadow:0 8px 24px rgba(28,15,7,0.2);display:flex;align-items:center;justify-content:center;gap:0.5rem;"
                        onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 12px 28px rgba(28,15,7,0.3)';"
                        onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 24px rgba(28,15,7,0.2)';"
                        onmousedown="this.style.transform='scale(0.98)';"
                        onmouseup="this.style.transform='translateY(-1px)';">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:17px;height:17px;">
                        @if($uniqueCode ?? null)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                        @endif
                    </svg>
                    {{ ($uniqueCode ?? null) ? 'Crear mi tarjeta' : 'Abrir mi tarjeta' }}
                </button>
            </form>

            <div class="divider fade-up d400" style="margin:1.8rem 0 1.2rem;"></div>

            <p class="fade-up d500" style="text-align:center;font-size:0.76rem;color:var(--latte);line-height:1.6;">
                ¿No tienes una tarjeta aún?<br>
                Escanea el QR del producto o ingresa su código directamente.
            </p>

        </div>
    </div>

</div>

<style>
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.75); }
    }
    @media (min-width: 900px) {
        .hidden-mobile-nav { display: flex !important; }
        .panel-left { min-height: 100vh !important; }
    }
    @media (max-width: 899px) {
        .hidden-mobile-nav { display: none !important; }
        .panel-right { padding-top: 2.5rem !important; }
    }
</style>

<script>
(function () {
    const card = document.querySelector('.hero-card');
    const states = [
        {
            id: 'receiver',
            header: 'Tu tarjeta te espera',
            name: '¿Para quién es? 🎁',
            msg: '"Ingresa tu palabra clave para descubrir el mensaje que alguien especial te dejó."',
            tagline: 'Un mensaje<br><em>guardado para ti</em>',
            sub: 'Alguien creó una tarjeta especial con tu nombre. Accede con tu palabra clave secreta.',
        },
        {
            id: 'creator',
            header: 'Nueva tarjeta · En creación',
            name: 'Tu destinatario 🎁',
            msg: '"Usa el código de acceso para personalizar la tarjeta con tu mensaje."',
            tagline: 'Crea tu<br><em>mensaje especial</em>',
            sub: 'Ingresa el código de acceso en el formulario para comenzar a personalizar la tarjeta.',
        }
    ];
    let idx = 0;

    function next() {
        idx = (idx + 1) % states.length;
        const s = states[idx];

        card.style.opacity = '0';
        card.style.transform = 'translateY(6px)';

        setTimeout(() => {
            document.getElementById('card-header-text').textContent = s.header;
            document.getElementById('card-name').textContent = s.name;
            document.getElementById('card-msg').textContent = s.msg;
            document.getElementById('tagline-text').innerHTML = s.tagline;
            document.getElementById('panel-sub-text').textContent = s.sub;

            const isCreator = s.id === 'creator';
            document.getElementById('footer-receiver').style.display = isCreator ? 'none' : 'flex';
            document.getElementById('footer-creator').style.display  = isCreator ? 'flex' : 'none';

            document.getElementById('label-receiver').style.color = isCreator ? 'rgba(255,255,255,0.25)' : 'rgba(255,255,255,0.7)';
            document.getElementById('label-creator').style.color  = isCreator ? 'rgba(255,255,255,0.7)'  : 'rgba(255,255,255,0.25)';

            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 300);
    }

    setInterval(next, 4000);
})();
</script>

</body>
</html>