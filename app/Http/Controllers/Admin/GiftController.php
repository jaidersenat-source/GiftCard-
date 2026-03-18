<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use Illuminate\Http\Request;

class GiftController extends Controller {

    public function index(Request $request) {
        $query = Gift::with(['product', 'giftCard'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('access_key', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhereHas('product', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        $gifts = $query->paginate(20)->withQueryString();
        return view('admin.gifts.index', compact('gifts'));
    }

    public function destroy(Gift $gift) {
        $gift->delete();
        return redirect()->route('admin.gifts.index')->with('success', 'Tarjeta eliminada.');
    }
}