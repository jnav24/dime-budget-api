<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Medical
 *
 * @property int $id
 * @property int $budget_id
 * @property string $name
 * @property string $amount
 * @property int $due_date
 * @property int $medical_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $paid_date
 * @property string|null $confirmation
 * @property int $not_track_amount
 * @property string|null $notes
 * @property-read \App\Models\MedicalType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Medical newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medical newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medical query()
 * @mixin \Eloquent
 */
class Medical extends Model
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
        'medical_type_id' => null,
        'paid_date' => null,
        'confirmation' => null,
        'not_track_amount' => null,
        'budget_id' => null,
        'notes' => null,
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
        'medical_type_id',
        'paid_date',
        'confirmation',
        'not_track_amount',
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
    protected $table = 'medical';

    /**
     * @return HasOne
     */
    public function type()
    {
        return $this->hasOne(MedicalType::class, 'id', 'medical_type_id');
    }
}
