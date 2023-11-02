<?php

namespace App\Models;

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
        $diff = $this->created_at->diff(now());

        return $this->getRemainingTime($diff);
    }

    public function getRemainingTime($diff): string
    {
        $remainingTime = '';
        if ($diff->days >= 365){
            $year = floor($diff->days / 365);
            $remainingTime = '> ' . $year . ' года';
        } elseif ($diff->days >= 60){
            $months = floor($diff->days / 60);
            $remainingTime = '> ' . $months . ' месяцев';
        } elseif ($diff->days >= 30) {
            $months = floor($diff->days / 30);
            $remainingTime = '> ' . $months . ' месяца';
        } elseif ($diff->days >= 7) {
            $weeks = floor($diff->days / 7);
            $remainingTime = '> ' . $weeks . ' недели';
        } elseif ($diff->days >= 1) {
            $remainingTime = $diff->days . ' ' . $this->getDaySuffix($diff->days);
        } elseif ($diff->h >= 1) {
            $remainingTime = $diff->h . ' ' . $this->getHourSuffix($diff->h);
        } else {
            $remainingTime = 'Меньше часа';
        }

        return $remainingTime;
    }

    private function getDaySuffix($days): string
    {
        $lastDigit = $days % 10;

        if ($lastDigit == 1 && $days != 11) {
            return 'день';
        } elseif (in_array($lastDigit, [2, 3, 4]) && !in_array($days, [12, 13, 14])) {
            return 'дня';
        } else {
            return 'дней';
        }
    }

    private function getHourSuffix($hours): string
    {
        $lastDigit = $hours % 10;

        if ($lastDigit == 1 && $hours != 11) {
            return 'час';
        } elseif (in_array($lastDigit, [2, 3, 4]) && !in_array($hours, [12, 13, 14])) {
            return 'часа';
        } else {
            return 'часов';
        }
    }
}
