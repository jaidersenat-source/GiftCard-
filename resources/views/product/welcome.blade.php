<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GiftCard QR · {{ $product->name }}</title>
    <script>window.__initialStep = {{ $initialStep }};</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes popIn {
            0%   { transform: scale(0.5); opacity: 0; }
            70%  { transform: scale(1.06); }
            100% { transform: scale(1);   opacity: 1; }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes shine {
            0%   { background-position: -200% center; }
            100% { background-position:  200% center; }
        }
        .pop      { animation: popIn   .55s cubic-bezier(.34,1.56,.64,1) forwards; }
        .su-0     { animation: slideUp .45s ease .05s forwards; opacity: 0; }
        .su-1     { animation: slideUp .45s ease .18s forwards; opacity: 0; }
        .su-2     { animation: slideUp .45s ease .30s forwards; opacity: 0; }
        .su-3     { animation: slideUp .45s ease .42s forwards; opacity: 0; }
        .code-glow {
            background: linear-gradient(90deg, #C9A84C 0%, #F0DB8C 45%, #C9A84C 60%, #A07830 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shine 3s linear infinite;
        }
        body { transition: background-color .5s ease; }

        /* Modal slide-up en mobile */
        .modal-sheet {
            transform: translateY(100%);
            transition: transform .35s cubic-bezier(.32,0,.67,0);
        }
        .modal-sheet.open {
            transform: translateY(0);
            transition: transform .35s cubic-bezier(.33,1,.68,1);
        }
    </style>
</head>

<body
    x-data="{
        step: window.__initialStep || 1,
        modalOpen: false,
        selectedCard: null,
        giftCards: {{ $giftCards->toJson() }},
        openModal(card) {
            this.selectedCard = card;
            this.modalOpen = true;
            this.$nextTick(() => {
                const i = this.$refs.recipientInput;
                if (i) i.focus();
            });
        }
    }"
    :style="step === 1
        ? 'background: linear-gradient(160deg, #1A1208 0%, #2d1a09 60%, #1A1208 100%);'
        : 'background-color: #FAF7F0;'"
    class="min-h-screen">


    {{-- ═══ HEADER ═══ --}}
    <header class="sticky top-0 z-40 px-5 py-3.5 transition-all duration-500"
            :class="step === 1 ? 'bg-black/20 backdrop-blur-md' : 'bg-white/80 backdrop-blur-md border-b border-stone-200/60'">
        <div class="max-w-lg mx-auto flex items-center justify-between">
            <a href="{{ route('landing') }}"
               class="font-bold text-lg tracking-tight transition-colors duration-500"
               :style="step === 1 ? 'color:#C9A84C' : 'color:#8b5a2b'">
                🎁 GiftCard
            </a>
            <a href="{{ route('login') }}"
               class="text-xs font-semibold px-3.5 py-1.5 rounded-full transition-all duration-300"
               :class="step === 1
                   ? 'bg-white/10 text-white/70 border border-white/15 hover:bg-white/20'
                   : 'text-stone-600 bg-stone-100 hover:bg-stone-200'">
                Admin
            </a>
        </div>
    </header>


    {{-- ═══ PASO 1 — Verificar código ═══ --}}
    <div x-show="step === 1"
         x-transition:enter="transition ease-out duration-350"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="min-h-[calc(100vh-56px)] flex flex-col items-center justify-center p-5">

        <div class="w-full max-w-sm">

            {{-- Icono + producto --}}
            <div class="text-center mb-8 su-0">
                <div class="pop inline-flex w-20 h-20 rounded-3xl items-center justify-center text-4xl mb-5 shadow-2xl"
                     style="background: linear-gradient(135deg,#C9A84C,#E8C97A);">🎁</div>
                <p class="text-xs font-semibold tracking-[0.14em] uppercase mb-1" style="color:#C9A84C;">Producto</p>
                <h1 class="text-2xl font-bold" style="color:#fff;">{{ $product->name }}</h1>
            </div>

            {{-- Código de acceso --}}
            <div class="su-1 rounded-3xl p-6 text-center mb-4"
                 style="background:rgba(255,255,255,.08);border:1px solid rgba(201,168,76,.35);backdrop-filter:blur(8px);">
                <p class="text-xs font-semibold tracking-[0.12em] uppercase mb-3" style="color:rgba(255,255,255,.55);">Tu código de acceso</p>
                <div class="font-mono text-5xl font-extrabold tracking-widest mb-3 code-glow">{{ $uniqueCode }}</div>
                <p class="text-xs" style="color:rgba(201,168,76,.75);">Anota este código — lo necesitas ahora</p>
            </div>

            {{-- Pasos rápidos --}}
            <div class="su-2 flex gap-2 mb-6">
                @foreach(['Anota el código','Ingrésalo abajo','Elige tu tarjeta'] as $i => $txt)
                <div class="flex-1 flex flex-col items-center gap-1.5 rounded-2xl py-3 px-2"
                     style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.08);">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                          style="background:rgba(201,168,76,.25);color:#E8C97A;">{{ $i+1 }}</span>
                    <span class="text-xs text-center leading-tight" style="color:rgba(255,255,255,.75);">{{ $txt }}</span>
                </div>
                @endforeach
            </div>

            {{-- Formulario --}}
            <div class="su-3">
                <form method="POST" action="{{ route('product.enter', $product->product_code) }}" class="space-y-3">
                    @csrf

                    @error('unique_code')
                    <div class="rounded-2xl px-4 py-3 text-sm text-center"
                         style="background:rgba(185,28,28,.12);border:1px solid rgba(185,28,28,.25);color:#fca5a5;">
                        ⚠️ {{ $message }}
                    </div>
                    @enderror

                    <input type="text"
                           name="unique_code"
                           value="{{ old('unique_code') }}"
                           placeholder="Ingresa tu código — ej: XK9-2MF"
                           maxlength="10"
                           @if($initialStep === 1) autofocus @endif
                           autocomplete="off"
                           class="w-full px-5 py-4 rounded-2xl text-white text-center text-xl font-mono tracking-widest
                                  placeholder:text-white/40 placeholder:text-sm placeholder:font-sans placeholder:tracking-normal
                                  focus:outline-none transition"
                           style="background:rgba(255,255,255,.08);border:1.5px solid rgba(255,255,255,.15);"
                           onfocus="this.style.borderColor='rgba(201,168,76,.5)';this.style.boxShadow='0 0 0 3px rgba(201,168,76,.12)';"
                           onblur="this.style.borderColor='rgba(255,255,255,.1)';this.style.boxShadow='none';">

                    <button type="submit"
                            class="w-full py-4 rounded-2xl font-bold text-base shadow-xl transition-transform active:scale-[.98]"
                            style="background:linear-gradient(135deg,#C9A84C,#E8C97A);color:#1A1208;">
                        Entrar a mis tarjetas →
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('gift.access') }}"
                       class="text-xs transition-colors"
                       style="color:rgba(201,168,76,.75);"
                       onmouseover="this.style.color='#E8C97A'"
                       onmouseout="this.style.color='rgba(201,168,76,.75)'">
                        ¿Recibes un regalo? Acceder con mi palabra clave →
                    </a>
                </div>
            </div>

        </div>
    </div>


    {{-- ═══ PASO 2 — Elegir tarjeta ═══ --}}
    <div x-show="step === 2"
         x-transition:enter="transition ease-out duration-350"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="max-w-lg mx-auto px-4 pt-6 pb-10">

        {{-- Cabecera --}}
        <div class="text-center mb-6">
            <p class="text-xs font-semibold tracking-[0.12em] uppercase text-stone-400 mb-1">{{ $product->name }}</p>
            <h1 class="text-2xl font-bold" style="color:#1c0f07;">Elige un diseño</h1>
            <p class="text-stone-400 text-sm mt-1">Selecciona la plantilla que más te guste</p>
        </div>

        {{-- Grid de tarjetas --}}
        <div class="grid grid-cols-2 gap-3">
            <template x-for="card in giftCards" :key="card.id">
                <button @click="openModal(card)"
                        class="relative overflow-hidden rounded-2xl shadow-md active:scale-[.96] transition-transform duration-150 text-left"
                        :style="({
                            gold:  'background:linear-gradient(145deg,#78350f,#ca8a04);border:1px solid rgba(234,179,8,.25)',
                            rose:  'background:linear-gradient(145deg,#881337,#db2777);border:1px solid rgba(236,72,153,.25)',
                            sage:  'background:linear-gradient(145deg,#064e3b,#0d9488);border:1px solid rgba(52,211,153,.25)',
                            navy:  'background:linear-gradient(145deg,#0f172a,#1d4ed8);border:1px solid rgba(96,165,250,.25)',
                            cream: 'background:linear-gradient(145deg,#3b3836,#78716c);border:1px solid rgba(168,162,158,.25)',
                        })[card.design] || 'background:linear-gradient(145deg,#1f2937,#4b5563)'">
                    <div class="p-4 flex flex-col gap-12">
                        {{-- Cabecera de la tarjeta --}}
                        <div class="flex items-center justify-between">
                            <div class="flex gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/30 block"></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-white/30 block"></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-white/30 block"></span>
                            </div>
                            <span class="text-lg">🎁</span>
                        </div>
                        {{-- Info --}}
                        <div>
                            <p class="text-white/50 text-xs mb-0.5">Plantilla</p>
                            <p class="text-white font-semibold text-sm leading-tight" x-text="card.title"></p>
                            <p class="text-white/60 text-xs mt-1 leading-snug line-clamp-2" x-text="card.description"></p>
                        </div>
                    </div>
                    {{-- Hover overlay --}}
                    <div class="absolute inset-0 bg-white/0 hover:bg-white/5 transition-colors duration-200 pointer-events-none"></div>
                </button>
            </template>
        </div>

        <div class="mt-8 text-center border-t border-stone-200 pt-5">
            <a href="{{ route('gift.access') }}"
               class="text-sm font-medium underline underline-offset-2"
               style="color:#8b5a2b;">
                ¿Ya tienes una tarjeta? Acceder con mi clave →
            </a>
        </div>

    </div>


    {{-- ═══ MODAL — Personalizar tarjeta ═══ --}}
    <div x-show="modalOpen"
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-end sm:items-center justify-center sm:p-4"
         style="display:none;">

        {{-- Backdrop --}}
        <div @click="modalOpen = false"
             class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        {{-- Sheet --}}
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full sm:translate-y-4 sm:opacity-0"
             x-transition:enter-end="translate-y-0 sm:opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 sm:opacity-100"
             x-transition:leave-end="translate-y-full sm:translate-y-4 sm:opacity-0"
             class="relative w-full sm:max-w-md bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden">

            {{-- Handle para mobile --}}
            <div class="flex justify-center pt-3 pb-1 sm:hidden">
                <div class="w-10 h-1 rounded-full bg-stone-200"></div>
            </div>

            {{-- Encabezado del modal --}}
            <div class="flex items-center justify-between px-6 pt-4 pb-2">
                <div>
                    <h2 class="text-lg font-bold" style="color:#1c0f07;">Personaliza tu tarjeta</h2>
                    <p class="text-stone-400 text-xs mt-0.5" x-text="selectedCard ? selectedCard.title : ''"></p>
                </div>
                <button @click="modalOpen = false"
                        class="w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 flex items-center justify-center text-stone-500 transition-colors text-sm font-medium">
                    ✕
                </button>
            </div>

            {{-- Formulario --}}
            <form method="POST" action="{{ route('gift.store') }}" class="px-6 pt-3 pb-8 space-y-4">
                @csrf
                <input type="hidden" name="gift_card_id" :value="selectedCard ? selectedCard.id : ''">

                @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-3 space-y-0.5">
                    @foreach($errors->all() as $e)
                        <p class="text-rose-600 text-xs">• {{ $e }}</p>
                    @endforeach
                </div>
                @endif

                <div>
                    <label class="block text-xs font-semibold text-stone-600 mb-1.5">Para</label>
                    <input x-ref="recipientInput"
                           type="text" name="recipient_name" value="{{ old('recipient_name') }}"
                           placeholder="Nombre del destinatario" maxlength="100" required
                           class="w-full px-4 py-3 rounded-xl bg-stone-50 border border-stone-200 text-sm transition
                                  focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-stone-600 mb-1.5">Mensaje</label>
                    <textarea name="message" placeholder="Escribe tu mensaje especial…"
                              maxlength="500" rows="3" required
                              class="w-full px-4 py-3 rounded-xl bg-stone-50 border border-stone-200 text-sm resize-none transition
                                     focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">{{ old('message') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-stone-600 mb-1.5">
                        Palabra clave
                        <span class="font-normal text-stone-400">— para que el destinatario acceda</span>
                    </label>
                    <input type="text" name="access_key" value="{{ old('access_key') }}"
                           placeholder="ej: sol, regalo2024" maxlength="50"
                           pattern="[a-zA-Z0-9]+" required
                           class="w-full px-4 py-3 rounded-xl bg-stone-50 border border-stone-200 text-sm transition
                                  focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20">
                    <p class="text-xs text-stone-400 mt-1">Solo letras y números, sin espacios.</p>
                </div>

                <button type="submit"
                        class="w-full py-4 rounded-2xl font-semibold text-white text-sm shadow-lg active:scale-[.98] transition-transform"
                        style="background:linear-gradient(135deg,#C9A84C,#E8C97A);color:#1A1208;">
                    Crear mi tarjeta ✨
                </button>
            </form>
        </div>
    </div>


    {{-- Re-abrir modal si hay errores --}}
    @if($errors->any() && $initialStep === 2)
    <script>
        document.addEventListener('alpine:init', () => {
            setTimeout(() => {
                const el = document.querySelector('[x-data]');
                if (el && el._x_dataStack) {
                    const d = el._x_dataStack[0];
                    if (d) d.modalOpen = true;
                }
            }, 150);
        });
    </script>
    @endif

</body>
</html>
    