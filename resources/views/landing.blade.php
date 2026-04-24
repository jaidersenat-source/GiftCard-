<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GiftCard · Tarjetas de regalo para amantes del café</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="/img/logo.png">
</head>
<body>

<div class="page-wrapper">

    <!-- ══ PANEL IZQUIERDO ══ -->
    <div class="panel-left">
        <div class="ring-deco"></div>
        <div class="ring-deco-2"></div>

        <!-- Tarjeta flotante del hero -->
        <div class="hero-card">
            <div class="hero-card-logo">
                <div class="card-dot"></div>
                <span>Café Gift Card</span>
            </div>
            <p class="hero-card-to">Para</p>
            <p class="hero-card-name">Valentina ☕</p>
            <p class="hero-card-msg">"Porque sé que tu día empieza con un buen café y con personas que te quieren."</p>
            <div class="hero-card-footer">
                <div class="hero-card-key">
                    <span>Clave:</span>
                    <strong>ABEJITA</strong>
                </div>
                <div class="hero-card-beans">
                    <div class="bean"></div>
                    <div class="bean"></div>
                    <div class="bean"></div>
                </div>
            </div>
        </div>

        <!-- Texto del panel -->
        <div class="panel-left-text">
            <h2 class="panel-tagline">
                Un regalo que<br>
                <em>sabe a café</em>
            </h2>
            <p class="panel-sub">
                Digital, personalizado y con mucho amor. La tarjeta perfecta para los amantes del café.
            </p>
        </div>
    </div>

    <!-- ══ PANEL DERECHO ══ -->
    <div class="panel-right">

        <div class="badge fade-up">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
            Café Gift Cards
        </div>

        <h1 class="section-heading fade-up d100">
            Tarjetas de regalo<br>
            <span>para amantes del café</span>
        </h1>
        <p class="section-sub fade-up d200">
            Sorprende a alguien especial con una tarjeta digital personalizada. Escanea, personaliza y comparte el aroma del café.
        </p>

        <!-- Acciones -->
        <div class="action-grid fade-up d300">
            <a href="{{ route('gift.access') }}" class="action-card primary">
                <div class="action-icon red">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <div class="action-text">
                    <p class="action-title">Ver mi tarjeta</p>
                    <p class="action-desc">Ingresa tu palabra clave secreta</p>
                </div>
                <div class="action-arrow">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <a href="#" class="action-card secondary">
                <div class="action-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h2M4 12h2m6 8h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <div class="action-text">
                    <p class="action-title">Crear una tarjeta</p>
                    <p class="action-desc">Escanea el código QR del producto</p>
                </div>
                <div class="action-arrow">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </div>

        <!-- Divisor pasos -->
        <div class="divider fade-up d400"><span>¿Cómo funciona?</span></div>

        <!-- Pasos -->
        <div class="steps fade-up d500">
            <div class="step">
                <div class="step-icon c1">1</div>
                <div class="step-body">
                    <p class="step-title">Escanea el QR</p>
                    <p class="step-desc">Apunta la cámara de tu celular al código QR del producto.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon c2">2</div>
                <div class="step-body">
                    <p class="step-title">Elige tu diseño</p>
                    <p class="step-desc">Selecciona la plantilla que más te guste para tu tarjeta.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon c3">3</div>
                <div class="step-body">
                    <p class="step-title">Personaliza el mensaje</p>
                    <p class="step-desc">Escribe el nombre del destinatario y tu mensaje especial.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon c4">4</div>
                <div class="step-body">
                    <p class="step-title">Comparte la tarjeta</p>
                    <p class="step-desc">Tu destinatario la abre con su palabra clave secreta.</p>
                </div>
            </div>
        </div>

        <!-- Puntos decorativos -->
        <div class="dots">
            <div class="dot d1"></div>
            <div class="dot d2"></div>
            <div class="dot d3"></div>
        </div>

        <footer class="panel-footer">
            <p class="footer-copy">&copy; {{ date('Y') }} Café Gift Cards · Hecho con amor y café</p>
            <a href="{{ route('login') }}" class="footer-admin">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Acceso administrador
            </a>
        </footer>

    </div>

</div>

</body>
</html>

