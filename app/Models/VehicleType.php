<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VehicleType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleType query()
 * @mixin \Eloquent
 */
class VehicleType extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'vehicle_types';

    /**
     * Hide columns
     *
     * @var array
     */
    protected $hidden= [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
}
