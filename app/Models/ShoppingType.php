<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShoppingType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShoppingType query()
 * @mixin \Eloquent
 */
class ShoppingType extends Model
{
    protected $table = 'shopping_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
