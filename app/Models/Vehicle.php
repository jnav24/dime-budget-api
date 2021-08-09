<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Vehicle
 *
 * @property int $id
 * @property int $budget_id
 * @property string $mileage
 * @property string $amount
 * @property int $due_date
 * @property int $user_vehicle_id
 * @property int $vehicle_type_id
 * @property string|null $paid_date
 * @property string|null $confirmation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $not_track_amount
 * @property string|null $notes
 * @property string $balance
 * @property-read \App\Models\VehicleType|null $type
 * @property-read \App\Models\UserVehicle|null $userVehicle
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle query()
 * @mixin \Eloquent
 */
class Vehicle extends Model
{
    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'mileage' => null,
        'amount' => null,
        'due_date' => null,
        'user_vehicle_id' => null,
        'vehicle_type_id' => null,
        'paid_date' => null,
        'confirmation' => null,
        'not_track_amount' => null,
        'balance' => null,
        'budget_id' => null,
        'notes' => null,
    ];

    /**
     * Mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'mileage',
        'amount',
        'due_date',
        'user_vehicle_id',
        'vehicle_type_id',
        'paid_date',
        'confirmation',
        'not_track_amount',
        'balance',
        'budget_id',
        'notes',
    ];

    /**
     * Hide columns
     *
     * @var array
     */
    protected $hidden = [
        'budget_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'vehicles';

    /**
     * @return HasOne
     */
    public function type()
    {
        return $this->hasOne(VehicleType::class, 'id', 'vehicle_type_id');
    }

    /**
     * @return HasOne
     */
    public function userVehicle()
    {
        return $this->hasOne(UserVehicle::class, 'id', 'user_vehicle_id');
    }
}
