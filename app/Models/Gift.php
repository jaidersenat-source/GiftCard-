<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gift extends Model {
    use HasFactory;

    protected $fillable = [
        'product_id', 'gift_card_id', 'recipient_name',
        'message', 'access_key', 'unique_code'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function giftCard() {
        return $this->belongsTo(GiftCard::class);
    }
}