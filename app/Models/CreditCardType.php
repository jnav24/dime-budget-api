<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CreditCardType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardType query()
 * @mixin \Eloquent
 */
class CreditCardType extends Model
{
    protected $table = 'credit_card_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
