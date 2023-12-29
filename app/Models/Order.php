<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seller_id',
        'status',
        'date',
        'score',
        'comment',
        'pay',
        'price',
        'receiver',
        'receiver_phone',
        'receiver_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(orderdetail::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function message()
    {
        return $this->hasOne(message::class);
    }

}
