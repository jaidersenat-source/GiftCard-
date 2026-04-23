{{-- Preview del diseño --}}
@extends('admin.layouts.admin')
@section('title', 'Plantillas')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="font-display text-2xl text-espresso">Plantillas</h1>
        <p class="text-sm text-latte mt-0.5">Lista de plantillas disponibles.</p>
    </div>
    <a href="{{ route('admin.gift-cards.create') }}" class="btn btn-primary">Nueva plantilla</a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($giftCards as $card)
        @php $classes = $card->design_classes; @endphp
        <div class="rounded-2xl overflow-hidden border {{ $classes['border'] }} bg-white shadow-sm">
            <div class="h-28 relative overflow-hidden {{ $card->image_path ? '' : 'bg-gradient-to-br ' . $classes['bg'] }} flex flex-col items-center justify-center gap-1">
                @if($card->image_path)
                    <img src="{{ $card->image_url }}" alt="{{ $card->title }}" class="w-full h-full object-cover">
                @endif

                <span class="absolute bottom-2 left-2 px-2 py-0.5 rounded-full text-xs font-medium bg-black/30 text-white backdrop-blur-sm capitalize">
                    {{ $card->category }}
                </span>

                @unless($card->image_path)
                    <span class="text-white/90 font-display text-sm font-semibold text-center px-3 leading-tight">
                        {{ $card->title }}
                    </span>
                @endunless

                <span class="absolute top-2.5 right-2.5 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium backdrop-blur-sm {{ $card->active ? 'bg-white/15 text-white' : 'bg-black/20 text-white/50' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $card->active ? 'bg-white' : 'bg-white/40' }}"></span>
                    {{ $card->active ? 'Activa' : 'Inactiva' }}
                </span>
            </div>

            <div class="p-4">
                <h3 class="font-semibold text-espresso">{{ $card->title }}</h3>
                <p class="text-sm text-latte mt-1">{{ Str::limit($card->description, 80) }}</p>
                <div class="mt-3 flex items-center gap-2">
                    <a href="{{ route('admin.gift-cards.edit', $card) }}" class="text-sm text-caramel">Editar</a>
                    <form method="POST" action="{{ route('admin.gift-cards.destroy', $card) }}" onsubmit="return confirm('Eliminar plantilla?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-brand-red">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>No hay plantillas registradas.</p>
    @endforelse
</div>

<div class="mt-6">{{ $giftCards->links() }}</div>

@endsection