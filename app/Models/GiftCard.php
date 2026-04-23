<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GiftCard extends Model {
    use HasFactory;

    protected $fillable = ['title', 'design', 'image_path', 'category', 'description', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function gifts() {
        return $this->hasMany(Gift::class);
    }

    public function getImageUrlAttribute(): ?string
{
    return $this->image_path
        ? asset('storage/' . $this->image_path)
        : null;
}

    /** Retorna clases Tailwind según el diseño */
    public function getDesignClassesAttribute(): array {
        return match($this->design) {
            'gold'  => ['bg' => 'from-amber-900 to-yellow-600',  'accent' => 'text-yellow-300', 'border' => 'border-yellow-500/30'],
            'rose'  => ['bg' => 'from-rose-900 to-pink-600',     'accent' => 'text-pink-200',   'border' => 'border-pink-500/30'],
            'sage'  => ['bg' => 'from-emerald-900 to-teal-600',  'accent' => 'text-emerald-200','border' => 'border-emerald-500/30'],
            'navy'  => ['bg' => 'from-slate-900 to-blue-800',    'accent' => 'text-blue-200',   'border' => 'border-blue-500/30'],
            'cream' => ['bg' => 'from-stone-200 to-amber-100',   'accent' => 'text-stone-700',  'border' => 'border-stone-300'],
            default => ['bg' => 'from-gray-900 to-gray-700',     'accent' => 'text-gray-200',   'border' => 'border-gray-500/30'],
        };
    }
}