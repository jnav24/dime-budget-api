<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MedicalType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalType query()
 * @mixin \Eloquent
 */
class MedicalType extends Model
{
    protected $table = 'medical_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
