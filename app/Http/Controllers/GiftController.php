<?php
namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\GiftCard;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GiftController extends Controller {

    /** Vista principal: muestra plantillas disponibles */
    public function home() {
        // Si no hay producto en sesión, mostrar formulario de acceso
        $productId   = session('product_id');
        $productName = session('product_name');
        $uniqueCode  = session('unique_code');

        $giftCards = GiftCard::where('active', true)->get();

        return view('home', compact('giftCards', 'productId', 'productName', 'uniqueCode'));
    }

    /** Guarda la tarjeta creada */
    public function store(Request $request) {
        $request->validate([
            'gift_card_id'   => 'required|exists:gift_cards,id',
            'recipient_name' => 'required|string|max:100',
            'message'        => 'required|string|max:500',
            'access_key'     => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_num',
                // Verificar unicidad dentro del producto
                function($attr, $value, $fail) use ($request) {
                    $exists = Gift::where('access_key', strtolower($value))
                                  ->where('product_id', session('product_id'))
                                  ->exists();
                    if ($exists) {
                        $fail('Esa palabra clave ya está en uso para este producto. Elige otra.');
                    }
                }
            ],
        ], [
            'recipient_name.required' => 'El nombre del destinatario es obligatorio.',
            'message.required'        => 'El mensaje no puede estar vacío.',
            'access_key.required'     => 'Debes ingresar una palabra clave.',
            'access_key.alpha_num'    => 'La palabra clave solo puede contener letras y números.',
        ]);

        if (!session('product_id')) {
            return redirect()->route('gift.access')
                             ->with('error', 'Sesión expirada. Escanea el QR nuevamente.');
        }

        // Usar unique_code de sesión o generar uno si no existe
        $uniqueCode = session('unique_code') ?:
            strtoupper(substr(bin2hex(random_bytes(2)), 0, 3)) . '-' .
            strtoupper(substr(bin2hex(random_bytes(2)), 0, 3));

        $gift = Gift::create([
            'product_id'     => session('product_id'),
            'gift_card_id'   => $request->gift_card_id,
            'recipient_name' => $request->recipient_name,
            'message'        => $request->message,
            'access_key'     => strtolower($request->access_key),
            'unique_code'    => $uniqueCode,
        ]);

        return redirect()->route('gift.show', $gift->access_key)
                         ->with('success', '¡Tu tarjeta ha sido creada!');
    }

    /** Formulario de acceso: muestra código si viene del QR */
    public function accessForm(Request $request) {
        $uniqueCode = session('unique_code');
        return view('gift.access', compact('uniqueCode'));
    }

    /** Verifica si ingresó el código del QR (→ crear) o una palabra clave (→ ver) */
    public function accessSubmit(Request $request) {
        $request->validate([
            'access_key' => 'required|string',
        ], [
            'access_key.required' => 'Ingresa el código o tu palabra clave.',
        ]);

        $input = strtoupper(trim($request->access_key));

        // ¿Coincide con el código generado al escanear?
        if (session('unique_code') && $input === strtoupper(session('unique_code'))) {
            return redirect()->route('home');
        }

        // ¿Coincide con la palabra clave de una tarjeta existente?
        $gift = Gift::where('access_key', strtolower($input))->first();
        if ($gift) {
            return redirect()->route('gift.show', $gift->access_key);
        }

        return back()->withErrors([
            'access_key' => 'Código incorrecto. Revisa el código en pantalla o ingresa tu palabra clave.',
        ]);
    }

    /** Muestra la tarjeta personalizada */
    public function show(string $accessKey) {
        $gift = Gift::with(['giftCard', 'product'])
                    ->where('access_key', $accessKey)
                    ->firstOrFail();

        return view('gift.show', compact('gift'));
    }
}