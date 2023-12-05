<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_url',
        'content',
        'price',
        'quantity',
    ];


    public function ProductCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function CartItem(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function OrderDetail(): belongsTo
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
