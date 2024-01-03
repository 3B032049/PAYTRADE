<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'image_url',
        'content',
        'price',
        'quantity',
        'product_category_id',
        'seller_id',
        'status',
    ];

//    public function getImageUrlAttribute()
//    {
//        return $this->attributes['image_url'];
//    }


    public function ProductCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function CartItem(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
