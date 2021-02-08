<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PersonalType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalType query()
 * @mixin \Eloquent
 */
class PersonalType extends Model
{
    protected $table = 'personal_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
