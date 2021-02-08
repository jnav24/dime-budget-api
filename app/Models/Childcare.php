<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Childcare
 *
 * @property int $id
 * @property int $budget_id
 * @property int $childcare_type_id
 * @property string $name
 * @property string $amount
 * @property string|null $confirmation
 * @property int $not_track_amount
 * @property int $due_date
 * @property string|null $paid_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ChildcareType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Childcare newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Childcare newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Childcare query()
 * @mixin \Eloquent
 */
class Childcare extends Model
{
    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'name' => null,
        'amount' => null,
        'due_date' => null,
        'paid_date' => null,
        'confirmation' => null,
        'not_track_amount' => null,
        'childcare_type_id' => null,
        'budget_id' => null,
    ];

    /**
     * Mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'amount',
        'due_date',
        'paid_date',
        'confirmation',
        'not_track_amount',
        'childcare_type_id',
        'budget_id',
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
    protected $table = 'childcare';

    /**
     * @return HasOne
     */
    public function type()
    {
        return $this->hasOne(ChildcareType::class, 'id', 'bank_type_id');
    }
}
