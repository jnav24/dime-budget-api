<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CreditCardTemplate
 *
 * @property int $id
 * @property string $name
 * @property string $limit
 * @property string $last_4
 * @property string $exp_month
 * @property string $exp_year
 * @property string $apr
 * @property int $due_date
 * @property int $credit_card_type_id
 * @property int $budget_template_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $amount
 * @property string|null $balance
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCardTemplate query()
 * @mixin \Eloquent
 */
class CreditCardTemplate extends Model
{
    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'name' => null,
        'limit' => null,
        'last_4' => null,
        'exp_month' => null,
        'exp_year' => null,
        'apr' => null,
        'due_date' => null,
        'credit_card_type_id' => null,
        'amount' => null,
        'balance' => null,
        'budget_template_id' => null,
    ];

    /**
     * Mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'limit',
        'last_4',
        'exp_month',
        'exp_year',
        'apr',
        'due_date',
        'credit_card_type_id',
        'amount',
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
    protected $table = 'credit_card_templates';
}
