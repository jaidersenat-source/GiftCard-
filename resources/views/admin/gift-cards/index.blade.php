{{-- resources/views/admin/gift-cards/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Plantillas')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-2xl text-espresso">Plantillas</h1>
        <p class="text-xs text-latte mt-0.5">{{ $giftCards->count() }} plantillas disponibles</p>
    </div>
    <a href="{{ route('admin.gift-cards.create') }}" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nueva plantilla
    </a>
</div>

{{-- Grid --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse($giftCards as $card)
    @php $classes = $card->design_classes; @endphp

    <div class="card overflow-hidden p-0 group">

        {{-- Preview del diseño --}}
        <div class="bg-gradient-to-br {{ $classes['bg'] }} h-28 flex flex-col items-center justify-center gap-1 relative">
            <span class="text-white/90 font-display text-sm font-semibold text-center px-3 leading-tight">
                {{ $card->title }}
            </span>
            {{-- Indicador de estado encima --}}
            <span class="absolute top-2.5 right-2.5 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium backdrop-blur-sm
                {{ $card->active
                    ? 'bg-white/15 text-white'
                    : 'bg-black/20 text-white/50' }}">
                <span class="w-1.5 h-1.5 rounded-full {{ $card->active ? 'bg-white' : 'bg-white/40' }}"></span>
                {{ $card->active ? 'Activa' : 'Inactiva' }}
            </span>
        </div>

        {{-- Acciones --}}
        <div class="p-3 flex items-center justify-between">
            <a href="{{ route('admin.gift-cards.edit', $card) }}"
               class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                      text-latte hover:text-caramel hover:bg-cream transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </a>
            <button type="button"
                    data-delete-name="{{ $card->title }}"
                    data-delete-action="{{ route('admin.gift-cards.destroy', $card) }}"
                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                           text-latte hover:text-brand-red hover:bg-brand-red-lt transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Eliminar
            </button>
        </div>
    </div>

    @empty
    <div class="col-span-full py-12 text-center">
        <div class="flex flex-col items-center gap-2">
            <svg class="w-8 h-8 text-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
            </svg>
            <p class="text-sm text-latte">No hay plantillas creadas aún.</p>
            <a href="{{ route('admin.gift-cards.create') }}" class="btn btn-primary mt-1">
                Crear la primera
            </a>
        </div>
    </div>
    @endforelse
</div>

{{-- ═══ Modal de confirmación de borrado ═══ --}}
<div id="delete-modal-root"
     x-data="{ deleteModal: false, deleteName: '', deleteAction: '' }"
     @open-delete.window="deleteModal = true; deleteName = $event.detail.name; deleteAction = $event.detail.action"
     x-on:keydown.escape.window="deleteModal = false">

    <div x-show="deleteModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display:none;">

        <div @click="deleteModal = false"
             class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        <div x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl p-6">

            <div class="w-12 h-12 rounded-2xl bg-brand-red-lt flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <h3 class="text-center font-bold text-espresso mb-1">¿Eliminar plantilla?</h3>
            <p class="text-center text-sm text-latte mb-6">
                Se eliminará <strong class="text-espresso" x-text="deleteName"></strong> de forma permanente.
            </p>

            <div class="flex gap-3">
                <button @click="deleteModal = false"
                        class="flex-1 py-2.5 rounded-xl text-sm font-medium bg-foam text-latte hover:bg-cream transition-colors">
                    Cancelar
                </button>
                <form :action="deleteAction" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-red hover:bg-red-700 transition-colors">
                        Sí, eliminar
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('[data-delete-name]').forEach(btn => {
        btn.addEventListener('click', () => {
            window.dispatchEvent(new CustomEvent('open-delete', {
                detail: { name: btn.dataset.deleteName, action: btn.dataset.deleteAction }
            }));
        });
    });
</script>

@endsection