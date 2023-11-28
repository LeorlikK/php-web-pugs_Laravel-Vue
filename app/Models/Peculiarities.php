<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Peculiarities
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @method static \Database\Factories\PeculiaritiesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Peculiarities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peculiarities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Peculiarities query()
 * @method static \Illuminate\Database\Eloquent\Builder|Peculiarities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peculiarities whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Peculiarities whereTitle($value)
 * @mixin \Eloquent
 */
class Peculiarities extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    protected $table = 'peculiarities';
}
