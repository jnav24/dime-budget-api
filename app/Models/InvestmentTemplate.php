<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvestmentTemplate
 *
 * @property int $id
 * @property string $name
 * @property string $amount
 * @property int $investment_type_id
 * @property int $budget_template_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvestmentTemplate query()
 * @mixin \Eloquent
 */
class InvestmentTemplate extends Model
{
    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'name' => null,
        'amount' => null,
        'investment_type_id' => null,
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
        'investment_type_id',
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
    protected $table = 'investment_templates';
}
