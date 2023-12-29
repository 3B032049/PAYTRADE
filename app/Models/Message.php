<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'buyer_rating',
        'buyer_message',
        'seller_rating',
        'seller_message',

    ];
    public function order()
    {
        return $this->belongsTo(order::class);
    }

}
