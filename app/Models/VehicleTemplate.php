<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VehicleTemplate
 *
 * @property int $id
 * @property int $budget_template_id
 * @property string $mileage
 * @property string $amount
 * @property int $due_date
 * @property int $user_vehicle_id
 * @property int $vehicle_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $balance
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VehicleTemplate query()
 * @mixin \Eloquent
 */
class VehicleTemplate extends Model
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
        'balance' => null,
        'budget_template_id' => null,
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
        'balance',
        'budget_template_id',
    ];

    /**
     * Hide columns
     *
     * @var array
     */
    protected $hidden = [
        'budget_template_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'vehicle_templates';
}
