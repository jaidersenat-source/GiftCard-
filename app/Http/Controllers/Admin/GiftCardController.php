<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GiftCardController extends Controller
{
    private array $designs   = ['gold', 'rose', 'sage', 'navy', 'cream'];
    private array $categories = ['general', 'cumpleaños', 'aniversario', 'navidad', 'san valentin', 'otro'];

    public function index()
    {
        $giftCards = GiftCard::latest()->paginate(15);
        return view('admin.gift-cards.index', compact('giftCards'));
    }

    public function create()
    {
        return view('admin.gift-cards.create', [
            'designs'    => $this->designs,
            'categories' => $this->categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'category'    => 'required|in:' . implode(',', $this->categories),
            'design'      => 'required|in:' . implode(',', $this->designs),
            'image'       => 'nullable|image|mimes:png,jpg,jpeg|max:4096',
            'description' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')
                ->store('gift-cards', 'public');
        }

        unset($data['image']);

        GiftCard::create($data + ['active' => $request->boolean('active', true)]);

        return redirect()->route('admin.gift-cards.index')
            ->with('success', 'Plantilla creada.');
    }

    public function edit(GiftCard $giftCard)
    {
        return view('admin.gift-cards.edit', [
            'giftCard'   => $giftCard,
            'designs'    => $this->designs,
            'categories' => $this->categories,
        ]);
    }

    public function update(Request $request, GiftCard $giftCard)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'category'    => 'required|in:' . implode(',', $this->categories),
            'design'      => 'required|in:' . implode(',', $this->designs),
            'image'       => 'nullable|image|mimes:png,jpg,jpeg|max:4096',
            'description' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('image')) {
            // Borra la imagen anterior si existe
            if ($giftCard->image_path) {
                Storage::disk('public')->delete($giftCard->image_path);
            }
            $data['image_path'] = $request->file('image')
                ->store('gift-cards', 'public');
        }

        unset($data['image']);

        $giftCard->update($data + ['active' => $request->boolean('active')]);

        return redirect()->route('admin.gift-cards.index')
            ->with('success', 'Plantilla actualizada.');
    }

    public function destroy(GiftCard $giftCard)
    {
        if ($giftCard->image_path) {
            Storage::disk('public')->delete($giftCard->image_path);
        }
        $giftCard->delete();

        return redirect()->route('admin.gift-cards.index')
            ->with('success', 'Plantilla eliminada.');
    }
}