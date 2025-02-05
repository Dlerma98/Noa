<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'user_id', 'content', 'genre', 'console', 'type',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
