<?php

namespace App\Models;

use App\Models\Scopes\OrderByCreationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'user_id', 'genre_id', 'excerpt', 'content', 'category', 'type' ,'thumbnail',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    protected static function booted()
    {
        static::addGlobalScope(new OrderByCreationScope);
    }
}
