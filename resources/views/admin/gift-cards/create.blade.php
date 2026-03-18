{{-- resources/views/admin/gift-cards/create.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Nueva Plantilla')

@section('content')

<div class="max-w-lg">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('admin.gift-cards.index') }}"
           class="inline-flex items-center gap-1.5 text-xs text-latte hover:text-caramel transition-colors mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a plantillas
        </a>
        <h1 class="font-display text-2xl text-espresso">Nueva plantilla</h1>
        <p class="text-sm text-latte mt-0.5">Configura el diseño y la información de la plantilla.</p>
    </div>

    {{-- Formulario --}}
    <div class="card p-6">
        <form method="POST" action="{{ route('admin.gift-cards.store') }}" class="space-y-5">
            @csrf

            {{-- Título --}}
            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1.5">Título</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       placeholder="ej: Edición Especial"
                       class="input @error('title') border-brand-red focus:ring-brand-red/20 @enderror">
                @error('title')
                    <p class="text-brand-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Diseño --}}
            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-2">Diseño</label>
                <div class="grid grid-cols-5 gap-2">
                    @foreach($designs as $design)
                    @php
                    $bg = match($design) {
                        'gold'  => 'from-amber-900 to-yellow-600',
                        'rose'  => 'from-rose-900 to-pink-600',
                        'sage'  => 'from-emerald-900 to-teal-600',
                        'navy'  => 'from-slate-900 to-blue-800',
                        'cream' => 'from-stone-200 to-amber-100',
                        default => 'from-gray-400 to-gray-600',
                    };
                    @endphp
                    <label class="cursor-pointer group">
                        <input type="radio" name="design" value="{{ $design }}"
                               class="sr-only peer"
                               {{ old('design', 'gold') === $design ? 'checked' : '' }}>
                        <div class="h-10 rounded-xl bg-gradient-to-br {{ $bg }}
                                    ring-2 ring-transparent ring-offset-2
                                    peer-checked:ring-caramel
                                    group-hover:opacity-90
                                    transition-all"></div>
                        <p class="text-xs text-center mt-1 text-latte capitalize">{{ $design }}</p>
                    </label>
                    @endforeach
                </div>
                @error('design')
                    <p class="text-brand-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1.5">
                    Descripción
                    <span class="font-normal text-latte">(opcional)</span>
                </label>
                <textarea name="description" rows="2"
                          placeholder="Breve descripción de la plantilla..."
                          class="input resize-none">{{ old('description') }}</textarea>
            </div>

            {{-- Activa --}}
            <div class="flex items-center gap-3 py-1">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1" id="active" checked
                       class="w-4 h-4 rounded accent-caramel cursor-pointer">
                <label for="active" class="text-sm text-espresso cursor-pointer">
                    Plantilla activa
                </label>
            </div>

            {{-- Acciones --}}
            <div class="flex gap-3 pt-2 border-t border-cream">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar plantilla
                </button>
                <a href="{{ route('admin.gift-cards.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection