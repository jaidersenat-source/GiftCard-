<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory;

    protected $fillable = ['name', 'product_code', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function gifts() {
        return $this->hasMany(Gift::class);
    }

    /** Genera un product_code único */
    public static function generateCode(string $prefix = 'PROD'): string {
        do {
            $code = $prefix . '-' . strtoupper(bin2hex(random_bytes(4)));
        } while (self::where('product_code', $code)->exists());
        return $code;
    }
}