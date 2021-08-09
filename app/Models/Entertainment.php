<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Entertainment
 *
 * @property int $id
 * @property int $budget_id
 * @property int $entertainment_type_id
 * @property string $name
 * @property string $amount
 * @property string|null $confirmation
 * @property int $not_track_amount
 * @property string|null $notes
 * @property int $due_date
 * @property string|null $paid_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EntertainmentType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Entertainment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entertainment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Entertainment query()
 * @mixin \Eloquent
 */
class Entertainment extends Model
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
        'entertainment_type_id' => null,
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
        'paid_date',
        'confirmation',
        'not_track_amount',
        'entertainment_type_id',
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
    protected $table = 'entertainment';

    /**
     * @return HasOne
     */
    public function type()
    {
        return $this->hasOne(EntertainmentType::class, 'id', 'bank_type_id');
    }
}
