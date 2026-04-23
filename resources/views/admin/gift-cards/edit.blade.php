{{-- resources/views/admin/gift-cards/edit.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Editar Plantilla')

@section('content')
<div class="max-w-lg">

    <div class="mb-6">
        <a href="{{ route('admin.gift-cards.index') }}"
           class="inline-flex items-center gap-1.5 text-xs text-latte hover:text-caramel transition-colors mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a plantillas
        </a>
        <h1 class="font-display text-2xl text-espresso">Editar plantilla</h1>
        <p class="text-sm text-latte mt-0.5">Modifica el diseño y la información de la plantilla.</p>
    </div>

    <div class="card p-6">
        <form method="POST" action="{{ route('admin.gift-cards.update', $giftCard) }}"
              enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Título --}}
            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1.5">Título</label>
                <input type="text" name="title" value="{{ old('title', $giftCard->title) }}"
                       placeholder="ej: Cumpleaños Especial"
                       class="input @error('title') border-brand-red @enderror">
                @error('title')
                    <p class="text-brand-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Categoría --}}
            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1.5">Categoría</label>
                <select name="category" class="input @error('category') border-brand-red @enderror">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $giftCard->category) === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-brand-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Imagen --}}
            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1.5">
                    Imagen de plantilla
                    <span class="font-normal text-latte">(PNG o JPG, máx. 4 MB)</span>
                </label>

                {{-- Imagen actual --}}
                @if($giftCard->image_path)
                <div class="mb-3">
                    <p class="text-xs text-latte mb-1.5">Imagen actual:</p>
                    <img src="{{ $giftCard->image_url }}" alt="{{ $giftCard->title }}"
                         class="w-full max-h-48 object-cover rounded-xl border border-cream">
                    <p class="text-xs text-latte mt-1">Sube una nueva imagen para reemplazarla.</p>
                </div>
                @endif

                {{-- Drop zone --}}
                <label for="image-upload"
                       class="flex flex-col items-center justify-center gap-2 h-36 rounded-xl border-2 border-dashed border-cream hover:border-caramel cursor-pointer transition-colors bg-foam"
                       id="drop-zone">
                    <svg class="w-8 h-8 text-latte" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm text-latte" id="drop-label">
                        {{ $giftCard->image_path ? 'Haz clic para cambiar la imagen' : 'Haz clic o arrastra una imagen aquí' }}
                    </span>
                    <input type="file" name="image" id="image-upload" accept=".png,.jpg,.jpeg" class="sr-only">
                </label>

                {{-- Preview nueva imagen --}}
                <div id="image-preview" class="hidden mt-3">
                    <img id="preview-img" src="" alt="Preview"
                         class="w-full max-h-48 object-contain rounded-xl border border-cream">
                </div>

                @error('image')
                    <p class="text-brand-red text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Diseño (fallback si no hay imagen) --}}
            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1">
                    Color de fondo
                    <span class="font-normal text-latte">(se usa si no hay imagen)</span>
                </label>
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
                               {{ old('design', $giftCard->design) === $design ? 'checked' : '' }}>
                        <div class="h-10 rounded-xl bg-gradient-to-br {{ $bg }}
                                    ring-2 ring-transparent ring-offset-2
                                    peer-checked:ring-caramel
                                    group-hover:opacity-90 transition-all"></div>
                        <p class="text-xs text-center mt-1 text-latte capitalize">{{ $design }}</p>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-xs font-semibold text-espresso/60 mb-1.5">
                    Descripción <span class="font-normal text-latte">(opcional)</span>
                </label>
                <textarea name="description" rows="2"
                          placeholder="Breve descripción de la plantilla..."
                          class="input resize-none">{{ old('description', $giftCard->description) }}</textarea>
            </div>

            {{-- Activa --}}
            <div class="flex items-center gap-3 py-1">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1" id="active"
                       {{ $giftCard->active ? 'checked' : '' }}
                       class="w-4 h-4 rounded accent-caramel cursor-pointer">
                <label for="active" class="text-sm text-espresso cursor-pointer">Plantilla activa</label>
            </div>

            {{-- Acciones --}}
            <div class="flex gap-3 pt-2 border-t border-cream">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar cambios
                </button>
                <a href="{{ route('admin.gift-cards.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    const input      = document.getElementById('image-upload');
    const preview    = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const label      = document.getElementById('drop-label');

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) return;
        label.textContent = file.name;
        previewImg.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    });
</script>
@endsection