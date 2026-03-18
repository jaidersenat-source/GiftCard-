
@extends('layouts.app')
@section('title', 'Elige tu tarjeta')

@section('content')
<div x-data="{
    modalOpen: false,
    selectedCard: null,
    recipientName: '',
    message: '',
    accessKey: '',
    openModal(card) {
        this.selectedCard = card;
        this.modalOpen = true;
        this.$nextTick(() => this.$refs.recipientInput.focus());
    }
}">

    {{-- HERO --}}
    <div class="text-center mb-8 fade-up">
        @if($productName)
            <p class="text-xs font-medium tracking-widest uppercase text-stone-400 mb-1">Producto</p>
            <h1 class="font-display text-2xl font-bold" style="color: var(--dark);">{{ $productName }}</h1>
        @else
            <h1 class="font-display text-2xl font-bold" style="color: var(--dark);">Crea tu tarjeta</h1>
        @endif
        <p class="text-stone-500 text-sm mt-2">Elige un diseño y personalízalo</p>
    </div>

    {{-- GRID DE TARJETAS --}}
    <div class="grid grid-cols-2 gap-3">
        @foreach($giftCards as $index => $card)
        @php $classes = $card->design_classes; @endphp
        <button @click="openModal({{ $card->toJson() }})"
                class="fade-up-delay-{{ min($index + 1, 3) }} relative overflow-hidden rounded-2xl aspect-[3/4] bg-gradient-to-br {{ $classes['bg'] }} border {{ $classes['border'] }} shadow-lg active:scale-95 transition-transform duration-150 text-left p-4 flex flex-col justify-between group">

            {{-- Shimmer overlay --}}
            <div class="absolute inset-0 shimmer opacity-0 group-hover:opacity-100 transition-opacity"></div>

            {{-- Decoración --}}
            <div class="relative">
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-lg">🎁</div>
            </div>

            {{-- Info --}}
            <div class="relative">
                <p class="text-white/60 text-xs mb-1">Plantilla</p>
                <p class="text-white font-semibold text-sm leading-tight">{{ $card->title }}</p>
                @if($card->description)
                    <p class="{{ $classes['accent'] }} text-xs mt-1 leading-snug opacity-80">{{ Str::limit($card->description, 50) }}</p>
                @endif
            </div>
        </button>
        @endforeach
    </div>

    {{-- SEPARADOR --}}
    <div class="mt-8 pt-6 border-t border-stone-200 text-center fade-up-delay-3">
        <p class="text-stone-500 text-sm">¿Ya tienes una tarjeta?</p>
        <a href="{{ route('gift.access') }}"
           class="inline-block mt-2 text-sm font-medium underline underline-offset-2"
           style="color: var(--gold);">
            Acceder con mi palabra clave →
        </a>
    </div>

    {{-- ══════════════ MODAL ══════════════ --}}
    <div x-show="modalOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
         style="display: none;">

        {{-- Backdrop --}}
        <div @click="modalOpen = false"
             class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        {{-- Panel --}}
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             class="relative w-full sm:max-w-md bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden">

            {{-- Handle bar (mobile) --}}
            <div class="flex justify-center pt-3 sm:hidden">
                <div class="w-10 h-1 bg-stone-200 rounded-full"></div>
            </div>

            {{-- Header del modal --}}
            <div class="px-6 pt-4 pb-0 flex items-center justify-between">
                <div>
                    <h2 class="font-display text-lg font-bold" style="color: var(--dark);">Personaliza tu tarjeta</h2>
                    <p class="text-stone-400 text-xs mt-0.5" x-text="selectedCard ? selectedCard.title : ''"></p>
                </div>
                <button @click="modalOpen = false"
                        class="w-8 h-8 rounded-full bg-stone-100 flex items-center justify-center text-stone-500 hover:bg-stone-200">
                    ✕
                </button>
            </div>

            {{-- Formulario --}}
            <form method="POST" action="{{ route('gift.store') }}" class="px-6 pt-4 pb-8 space-y-4">
                @csrf
                <input type="hidden" name="gift_card_id" :value="selectedCard ? selectedCard.id : ''">

                {{-- Errores --}}
                @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-3">
                    @foreach($errors->all() as $error)
                        <p class="text-rose-600 text-xs">• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <div>
                    <label class="block text-xs font-semibold text-stone-600 mb-1.5">Para</label>
                    <input x-ref="recipientInput"
                           type="text"
                           name="recipient_name"
                           value="{{ old('recipient_name') }}"
                           placeholder="Nombre del destinatario"
                           maxlength="100"
                           class="w-full px-4 py-3 rounded-2xl bg-stone-50 border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 transition"
                           required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-stone-600 mb-1.5">Mensaje</label>
                    <textarea name="message"
                              placeholder="Escribe tu mensaje especial..."
                              maxlength="500"
                              rows="3"
                              class="w-full px-4 py-3 rounded-2xl bg-stone-50 border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 transition resize-none"
                              required>{{ old('message') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-stone-600 mb-1.5">
                        Palabra clave secreta
                        <span class="font-normal text-stone-400">(para acceder a la tarjeta)</span>
                    </label>
                    <input type="text"
                           name="access_key"
                           value="{{ old('access_key') }}"
                           placeholder="ej: amor, regalo2024"
                           maxlength="50"
                           pattern="[a-zA-Z0-9]+"
                           class="w-full px-4 py-3 rounded-2xl bg-stone-50 border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400/50 focus:border-amber-400 transition"
                           required>
                    <p class="text-xs text-stone-400 mt-1">Solo letras y números, sin espacios.</p>
                </div>

                <button type="submit"
                        class="w-full py-4 rounded-2xl font-semibold text-white text-sm shadow-lg active:scale-95 transition-transform"
                        style="background: linear-gradient(135deg, var(--gold), var(--gold-light));">
                    ✨ Crear mi tarjeta
                </button>
            </form>
        </div>
    </div>

    {{-- Re-abrir modal si hay error de validación --}}
    @if($errors->any())
    <script>
        document.addEventListener('alpine:init', () => {
            // Auto-abre el modal si viene de un error
            window.setTimeout(() => {
                document.querySelector('[x-data]').__x.$data.modalOpen = true;
            }, 100);
        });
    </script>
    @endif

</div>
@endsection