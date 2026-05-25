<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price_adjustment',
        'stock',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'stock'            => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getFinalPriceAttribute(): float
    {
        return round($this->product->price + $this->price_adjustment, 2);
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }
}
