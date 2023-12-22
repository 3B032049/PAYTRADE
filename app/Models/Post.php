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
        'is_feature',
        'file',
    ];

    protected $casts = [
        'title' => 'string',
        'content' => 'string',
        'is_feature' => 'bool',
        'file'=>'string',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
