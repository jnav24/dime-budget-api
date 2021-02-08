<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FoodType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FoodType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodType query()
 * @mixin \Eloquent
 */
class FoodType extends Model
{
    protected $table = 'food_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
