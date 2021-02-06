<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MiscellaneousTemplate
 *
 * @property int $id
 * @property int $budget_template_id
 * @property string $name
 * @property string $amount
 * @property int $due_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $not_track_amount
 * @method static \Illuminate\Database\Eloquent\Builder|MiscellaneousTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MiscellaneousTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MiscellaneousTemplate query()
 * @mixin \Eloquent
 */
class MiscellaneousTemplate extends Model
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
        'budget_template_id' => null,
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
    protected $table = 'miscellaneous_templates';
}
