<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TaxType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaxType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxType query()
 * @mixin \Eloquent
 */
class TaxType extends Model
{
    protected $table = 'tax_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
