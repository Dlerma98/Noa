<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'thumbnail', 'excerpt', 'content', 'category', 'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
