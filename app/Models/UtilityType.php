<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UtilityType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UtilityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UtilityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UtilityType query()
 * @mixin \Eloquent
 */
class UtilityType extends Model
{
    protected $table = 'utility_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
