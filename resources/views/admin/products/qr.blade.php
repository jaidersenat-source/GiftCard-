{{-- resources/views/admin/products/qr.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'Código QR · {{ $product->name }}')

@section('content')

<div class="max-w-sm mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}"
           class="inline-flex items-center gap-1.5 text-xs text-latte hover:text-caramel transition-colors mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a productos
        </a>
        <h1 class="font-display text-2xl text-espresso">Código QR</h1>
        <p class="text-sm text-latte mt-0.5">{{ $product->name }}</p>
    </div>

    {{-- Card QR --}}
    <div class="card p-8 text-center mb-4">

        {{-- QR --}}
        <div id="qr-container"
             class="inline-flex items-center justify-center bg-white rounded-2xl p-4 border border-cream mb-6">
            {!! QrCode::size(200)->generate(url('/product/' . $product->product_code)) !!}
        </div>

        {{-- Info --}}
        <div class="space-y-1">
            <code class="inline-block bg-cream text-caramel px-3 py-1 rounded-lg text-sm font-mono tracking-widest">
                {{ $product->product_code }}
            </code>
            <p class="text-xs text-latte break-all">
                {{ url('/product/' . $product->product_code) }}
            </p>
        </div>
    </div>

    {{-- Acciones --}}
    <div class="flex gap-3">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary flex-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver
        </a>
        <button id="btn-download-png" class="btn btn-primary flex-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Descargar PNG
        </button>
    </div>

</div>

{{-- Canvas oculto para SVG → PNG --}}
<canvas id="qr-canvas" style="display:none;"></canvas>

<script>
document.getElementById('btn-download-png').addEventListener('click', function () {
    const svgEl  = document.querySelector('#qr-container svg');
    const size   = 700;
    const canvas = document.getElementById('qr-canvas');
    canvas.width  = size;
    canvas.height = size;
    const ctx = canvas.getContext('2d');

    const clone = svgEl.cloneNode(true);
    clone.setAttribute('width', size);
    clone.setAttribute('height', size);
    const svgStr  = new XMLSerializer().serializeToString(clone);
    const svgBlob = new Blob([svgStr], { type: 'image/svg+xml;charset=utf-8' });
    const blobUrl = URL.createObjectURL(svgBlob);

    const img = new Image();
    img.onload = function () {
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, size, size);
        ctx.drawImage(img, 0, 0, size, size);
        URL.revokeObjectURL(blobUrl);
        canvas.toBlob(function (blob) {
            const a    = document.createElement('a');
            a.href     = URL.createObjectURL(blob);
            a.download = 'qr-{{ $product->product_code }}.png';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(a.href);
        }, 'image/png');
    };
    img.src = blobUrl;
});
</script>

@endsection