{{-- resources/views/admin/gifts/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Tarjetas Creadas')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-2xl text-espresso">Tarjetas creadas</h1>
        <p class="text-xs text-latte mt-0.5">{{ $gifts->total() }} tarjetas en total</p>
    </div>
</div>

{{-- Búsqueda --}}
<form method="GET" class="mb-5">
    <div class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Buscar por palabra clave, destinatario o producto..."
               class="input flex-1">
        <button type="submit" class="btn btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Buscar
        </button>
    </div>
    @if(request('search'))
    <div class="mt-2 flex items-center gap-2">
        <p class="text-xs text-latte">
            Resultados para <span class="font-semibold text-espresso">"{{ request('search') }}"</span>
        </p>
        <a href="{{ route('admin.gifts.index') }}"
           class="text-xs text-latte hover:text-brand-red transition-colors">
            × Limpiar
        </a>
    </div>
    @endif
</form>

{{-- Tabla --}}
<div class="card overflow-hidden p-0">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-cream bg-foam">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-latte uppercase tracking-wider">Para</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-latte uppercase tracking-wider">Palabra clave</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-latte uppercase tracking-wider hidden md:table-cell">Producto</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-latte uppercase tracking-wider hidden lg:table-cell">Plantilla</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-latte uppercase tracking-wider hidden sm:table-cell">Fecha</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cream">
                @forelse($gifts as $gift)
                <tr class="hover:bg-foam/60 transition-colors">

                    {{-- Destinatario --}}
                    <td class="px-5 py-3.5 font-medium text-espresso">
                        {{ $gift->recipient_name }}
                    </td>

                    {{-- Palabra clave --}}
                    <td class="px-5 py-3.5">
                        <a href="{{ route('gift.show', $gift->access_key) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 bg-cream text-caramel font-mono text-xs
                                  px-2.5 py-1 rounded-lg hover:bg-latte/20 transition-colors">
                            {{ $gift->access_key }}
                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </td>

                    {{-- Producto --}}
                    <td class="px-5 py-3.5 text-latte text-xs hidden md:table-cell">
                        {{ $gift->product->name }}
                    </td>

                    {{-- Plantilla --}}
                    <td class="px-5 py-3.5 text-latte text-xs hidden lg:table-cell">
                        {{ $gift->giftCard->title }}
                    </td>

                    {{-- Fecha --}}
                    <td class="px-5 py-3.5 text-latte text-xs hidden sm:table-cell">
                        {{ $gift->created_at->format('d/m/Y') }}
                    </td>

                    {{-- Eliminar --}}
                    <td class="px-5 py-3.5">
                        <button type="button"
                                data-delete-name="{{ $gift->recipient_name }}"
                                data-delete-action="{{ route('admin.gifts.destroy', $gift) }}"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                                       text-latte hover:text-brand-red hover:bg-brand-red-lt transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-8 h-8 text-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                            </svg>
                            <p class="text-sm text-latte">
                                {{ request('search') ? 'No se encontraron tarjetas.' : 'No hay tarjetas creadas aún.' }}
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if($gifts->hasPages())
    <div class="px-5 py-3 border-t border-cream">
        {{ $gifts->appends(request()->query())->links() }}
    </div>
    @endif
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

        {{-- Backdrop --}}
        <div @click="deleteModal = false"
             class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        {{-- Dialog --}}
        <div x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl p-6">

            {{-- Icono --}}
            <div class="w-12 h-12 rounded-2xl bg-brand-red-lt flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            {{-- Texto --}}
            <h3 class="text-center font-bold text-espresso mb-1">¿Eliminar tarjeta?</h3>
            <p class="text-center text-sm text-latte mb-6">
                Se eliminará la tarjeta de <strong class="text-espresso" x-text="deleteName"></strong> de forma permanente.
            </p>

            {{-- Acciones --}}
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