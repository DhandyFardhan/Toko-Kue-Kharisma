<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price', 
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get subtotal untuk item cart ini
     */
    public function getSubtotalAttribute()
    {
        // Gunakan price di cart (wajib ada untuk paket), fallback ke product price
        $price = $this->price ?? ($this->product->price ?? 0);
        return $this->quantity * $price;
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get total items di cart untuk user
     */
    public static function getTotalItems($userId)
    {
        return static::forUser($userId)->sum('quantity');
    }

    /**
     * Get total harga cart untuk user
     */
    public static function getTotalPrice($userId)
    {
        return static::forUser($userId)
            ->get()
            ->sum(function ($item) {
                // Tambahkan pengecekan null agar ID paket 100-102 tidak error
                $price = $item->price ?? ($item->product->price ?? 0);
                return $item->quantity * $price;
            });
    }
}