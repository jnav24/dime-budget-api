<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvestmentType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentType query()
 * @mixin \Eloquent
 */
class InvestmentType extends Model
{
    protected $table = 'investment_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
