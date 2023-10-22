<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'news';
//    protected $casts = [
//        'created_at' => 'datetime:Y-m-d'
//    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'news_id', 'id');
    }

//    public function getCreatedAtDifferenceAttribute(): string
//    {
//        $createdAt = Carbon::parse($this->created_at);
//
//        return $createdAt->diffForHumans(now());
//    }
}
