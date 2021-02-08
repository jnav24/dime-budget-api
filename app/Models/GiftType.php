<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GiftType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GiftType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GiftType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GiftType query()
 * @mixin \Eloquent
 */
class GiftType extends Model
{
    protected $table = 'gift_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
