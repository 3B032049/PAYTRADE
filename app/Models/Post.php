<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'posts_title',
        'posts_content',
        'is_feature',
        'file',
    ];

    protected $casts = [
        'posts_title' => 'string',
        'posts_content' => 'string',
        'is_feature' => 'bool',
        'file'=>'string',
    ];
}
