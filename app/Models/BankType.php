<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BankType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BankType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankType query()
 * @mixin \Eloquent
 */
class BankType extends Model
{
    protected $table = 'bank_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
