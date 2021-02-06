<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChildcareType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ChildcareType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChildcareType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChildcareType query()
 * @mixin \Eloquent
 */
class ChildcareType extends Model
{
    protected $table = 'childcare_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
