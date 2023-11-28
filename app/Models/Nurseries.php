<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Nurseries
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property string|null $address
 * @property string|null $phone
 * @property string $image_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\NurseriesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries query()
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nurseries whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Nurseries extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'nurseries';
}
