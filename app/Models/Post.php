<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'file',
    ];

    protected $casts = [
        'title' => 'string',
        'content' => 'string',
        'status' => 'integer',
        'file'=>'string',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
