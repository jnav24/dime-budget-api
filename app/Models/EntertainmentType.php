<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EntertainmentType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EntertainmentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EntertainmentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EntertainmentType query()
 * @mixin \Eloquent
 */
class EntertainmentType extends Model
{
    protected $table = 'entertainment_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
