<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller {

    public function index() {
        $products = Product::latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create() {
        $code = Product::generateCode();
        return view('admin.products.create', compact('code'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'         => 'required|string|max:200',
            'product_code' => 'required|string|unique:products,product_code',
        ]);
        Product::create($request->only('name', 'product_code') + ['active' => $request->boolean('active', true)]);
        return redirect()->route('admin.products.index')->with('success', 'Producto creado.');
    }

    public function edit(Product $product) {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        $request->validate([
            'name'         => 'required|string|max:200',
            'product_code' => 'required|string|unique:products,product_code,' . $product->id,
        ]);
        $product->update($request->only('name', 'product_code') + ['active' => $request->boolean('active')]);
        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado.');
    }

    /** Genera QR para el producto */
    public function qr(Product $product) {
        return view('admin.products.qr', compact('product'));
    }

    /** Descargar QR como PNG */
    public function downloadQr(Product $product) {
        $url = url('/product/' . $product->product_code);

        // Generar SVG primero (funciona sin imagick)
        $svg = QrCode::size(700)->generate($url);

        // Si Imagick está disponible, convertir SVG -> PNG y devolver como attachment
        if (extension_loaded('imagick')) {
            try {
                $im = new \Imagick();
                $im->setBackgroundColor(new \ImagickPixel('transparent'));
                $im->readImageBlob($svg);
                $im->setImageFormat('png32');
                // Flatten y obtener blob
                $im = $im->coalesceImages();
                $pngBlob = '';
                foreach ($im as $frame) {
                    $pngBlob .= $frame->getImageBlob();
                }

                return response($pngBlob, 200)
                    ->header('Content-Type', 'image/png')
                    ->header('Content-Disposition', 'attachment; filename="qr-'. $product->product_code .'.png"');
            } catch (\Exception $e) {
                // caida a SVG si falla la conversión
                return response($svg, 200)
                    ->header('Content-Type', 'image/svg+xml')
                    ->header('Content-Disposition', 'attachment; filename="qr-'. $product->product_code .'.svg"');
            }
        }

        // Si no hay Imagick, devolver SVG con aviso en filename
        return response($svg, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qr-'. $product->product_code .'.svg"');
    }
}