<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LoanType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LoanType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanType query()
 * @mixin \Eloquent
 */
class LoanType extends Model
{
    protected $table = 'loan_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
