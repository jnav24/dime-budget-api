<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TravelType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TravelType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TravelType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TravelType query()
 * @mixin \Eloquent
 */
class TravelType extends Model
{
    protected $table = 'travel_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
