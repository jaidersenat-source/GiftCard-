{{-- resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Productos')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-2xl text-espresso">Productos</h1>
        <p class="text-xs text-latte mt-0.5">{{ $products->total() }} productos registrados</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo producto
    </a>
</div>

{{-- Tabla --}}
<div class="card overflow-hidden p-0">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-cream bg-foam">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-latte uppercase tracking-wider">Nombre</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-latte uppercase tracking-wider">Código QR</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-latte uppercase tracking-wider">Estado</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-cream">
                @forelse($products as $product)
                <tr class="hover:bg-foam/60 transition-colors">

                    {{-- Nombre --}}
                    <td class="px-5 py-3.5 font-medium text-espresso">
                        {{ $product->name }}
                    </td>

                    {{-- Código --}}
                    <td class="px-5 py-3.5">
                        <code class="bg-cream text-caramel px-2.5 py-1 rounded-lg text-xs font-mono tracking-wider">
                            {{ $product->product_code }}
                        </code>
                    </td>

                    {{-- Estado --}}
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $product->active
                                ? 'bg-brand-green-lt text-brand-green'
                                : 'bg-cream text-latte' }}">
                            <span class="w-1.5 h-1.5 rounded-full
                                {{ $product->active ? 'bg-brand-green' : 'bg-latte' }}"></span>
                            {{ $product->active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>

                    {{-- Acciones --}}
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-1 justify-end">
                            <a href="{{ route('admin.products.qr', $product) }}"
                               class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                                      text-latte hover:text-caramel hover:bg-cream transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h2M4 12h2m6 8h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                                QR
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                                      text-latte hover:text-caramel hover:bg-cream transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                            <button type="button"
                                    data-delete-name="{{ $product->name }}"
                                    data-delete-action="{{ route('admin.products.destroy', $product) }}"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium
                                           text-latte hover:text-brand-red hover:bg-brand-red-lt transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-8 h-8 text-cream" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-sm text-latte">No hay productos aún.</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-1">
                                Crear el primero
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if($products->hasPages())
    <div class="px-5 py-3 border-t border-cream">
        {{ $products->links() }}
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
            <h3 class="text-center font-bold text-espresso mb-1">¿Eliminar producto?</h3>
            <p class="text-center text-sm text-latte mb-6">
                Se eliminará <strong class="text-espresso" x-text="deleteName"></strong> de forma permanente.
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
    // Los botones de la tabla despachan un evento custom con nombre y action
    document.querySelectorAll('[data-delete-name]').forEach(btn => {
        btn.addEventListener('click', () => {
            window.dispatchEvent(new CustomEvent('open-delete', {
                detail: { name: btn.dataset.deleteName, action: btn.dataset.deleteAction }
            }));
        });
    });
</script>

@endsection