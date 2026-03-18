{{-- resources/views/admin/products/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Nuevo Producto')

@section('content')

<div class="max-w-lg">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}"
           class="inline-flex items-center gap-1.5 text-xs text-latte hover:text-caramel transition-colors mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a productos
        </a>
        <h1 class="font-display text-2xl text-espresso">Nuevo producto</h1>
        <p class="text-sm text-latte mt-0.5">Completa los datos para registrar un nuevo producto.</p>
    </div>

    {{-- Formulario --}}
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-5">
            @csrf

            {{-- Nombre --}}
            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1.5">
                    Nombre del producto
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="ej: Caja de Chocolates Premium"
                       class="input @error('name') border-brand-red focus:ring-brand-red/20 @enderror">
                @error('name')
                    <p class="text-brand-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Código QR --}}
            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1.5">
                    Código QR
                    <span class="font-normal text-latte">(generado automáticamente)</span>
                </label>
                <input type="text" name="product_code" value="{{ old('product_code', $code) }}"
                       class="input font-mono tracking-widest @error('product_code') border-brand-red focus:ring-brand-red/20 @enderror">
                @error('product_code')
                    <p class="text-brand-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Activo --}}
            <div class="flex items-center gap-3 py-1">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1" id="active" checked
                       class="w-4 h-4 rounded accent-caramel">
                <label for="active" class="text-sm text-espresso cursor-pointer">
                    Producto activo
                </label>
            </div>

            {{-- Acciones --}}
            <div class="flex gap-3 pt-2 border-t border-cream">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar producto
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</div>

@endsection