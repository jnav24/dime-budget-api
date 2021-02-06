<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Miscellaneous
 *
 * @property int $id
 * @property int $budget_id
 * @property string $name
 * @property string $amount
 * @property int $due_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $paid_date
 * @property string|null $confirmation
 * @property int $not_track_amount
 * @method static \Illuminate\Database\Eloquent\Builder|Miscellaneous newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Miscellaneous newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Miscellaneous query()
 * @mixin \Eloquent
 */
class Miscellaneous extends Model
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
    protected $table = 'miscellaneous';
}
