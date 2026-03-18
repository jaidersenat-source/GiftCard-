<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {

    /**
     * QR escaneado → genera unique_code, guarda sesión, va a home.
     */
    public function scan(string $productCode) {
        $product = Product::where('product_code', $productCode)
                          ->where('active', true)
                          ->firstOrFail();

        // Generar código único cada vez que se escanea el QR
        $uniqueCode = strtoupper(substr(bin2hex(random_bytes(2)), 0, 3))
                    . '-'
                    . strtoupper(substr(bin2hex(random_bytes(2)), 0, 3));

        session([
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'unique_code'  => $uniqueCode,
        ]);

        return redirect()->route('gift.access');
    }

    public function enter(Request $request, string $productCode) {
        return redirect()->route('gift.access');
    }
}