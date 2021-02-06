<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HousingType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HousingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HousingType query()
 * @mixin \Eloquent
 */
class HousingType extends Model
{
    protected $table = 'housing_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
