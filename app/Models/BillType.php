<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BillType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $save_type
 * @property string $model
 * @method static \Illuminate\Database\Eloquent\Builder|BillType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillType query()
 * @mixin \Eloquent
 */
class BillType extends Model
{
    protected $table = 'bill_types';
}
