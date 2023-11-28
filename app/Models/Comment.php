<?php

namespace App\Models;

use App\Service\DateService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'comments';
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_comment', 'id');
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['created_at_diff'] = $this->getTimeToCreateDiffAttribute();
        return $array;
    }

    public function getTimeToCreateDiffAttribute(): string
    {
        $service = new DateService();
        $diff = $this->created_at->diff(now());

        return $service->getRemainingTime($diff);
    }
}
