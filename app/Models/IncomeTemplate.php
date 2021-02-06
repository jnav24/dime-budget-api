<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IncomeTemplate
 *
 * @property int $id
 * @property string $name
 * @property string $amount
 * @property int $budget_template_id
 * @property int $income_type_id
 * @property string $initial_pay_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IncomeTemplate query()
 * @mixin \Eloquent
 */
class IncomeTemplate extends Model
{
    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'name' => null,
        'amount' => null,
        'income_type_id' => null,
        'initial_pay_date' => null,
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
        'income_type_id',
        'initial_pay_date',
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
    protected $table = 'income_templates';
}
