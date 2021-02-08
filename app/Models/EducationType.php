<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EducationType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EducationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EducationType query()
 * @mixin \Eloquent
 */
class EducationType extends Model
{
    protected $table = 'education_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
