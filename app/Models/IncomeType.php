<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IncomeType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeType query()
 * @mixin \Eloquent
 */
class IncomeType extends Model
{
    protected $table = 'income_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
