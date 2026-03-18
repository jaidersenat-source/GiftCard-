<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCard;
use Illuminate\Http\Request;

class GiftCardController extends Controller {

    public function index() {
        $giftCards = GiftCard::latest()->paginate(15);
        return view('admin.gift-cards.index', compact('giftCards'));
    }

    public function create() {
        $designs = ['gold', 'rose', 'sage', 'navy', 'cream'];
        return view('admin.gift-cards.create', compact('designs'));
    }

    public function store(Request $request) {
        $request->validate([
            'title'       => 'required|string|max:150',
            'design'      => 'required|in:gold,rose,sage,navy,cream',
            'description' => 'nullable|string|max:500',
        ]);
        GiftCard::create($request->only('title', 'design', 'description') + ['active' => $request->boolean('active', true)]);
        return redirect()->route('admin.gift-cards.index')->with('success', 'Plantilla creada.');
    }

    public function edit(GiftCard $giftCard) {
        $designs = ['gold', 'rose', 'sage', 'navy', 'cream'];
        return view('admin.gift-cards.edit', compact('giftCard', 'designs'));
    }

    public function update(Request $request, GiftCard $giftCard) {
        $request->validate([
            'title'       => 'required|string|max:150',
            'design'      => 'required|in:gold,rose,sage,navy,cream',
            'description' => 'nullable|string|max:500',
        ]);
        $giftCard->update($request->only('title', 'design', 'description') + ['active' => $request->boolean('active')]);
        return redirect()->route('admin.gift-cards.index')->with('success', 'Plantilla actualizada.');
    }

    public function destroy(GiftCard $giftCard) {
        $giftCard->delete();
        return redirect()->route('admin.gift-cards.index')->with('success', 'Plantilla eliminada.');
    }
}