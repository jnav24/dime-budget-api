<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\CreditCard
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
 * @property int $budget_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $paid_date
 * @property string|null $confirmation
 * @property string|null $amount
 * @property string|null $balance
 * @property string|null $notes
 * @property-read \App\Models\CreditCardType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditCard query()
 * @mixin \Eloquent
 */
class CreditCard extends Model
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
        'paid_date' => null,
        'confirmation' => null,
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
        'name',
        'limit',
        'last_4',
        'exp_month',
        'exp_year',
        'apr',
        'due_date',
        'credit_card_type_id',
        'amount',
        'paid_date',
        'confirmation',
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
    protected $table = 'credit_cards';

    /**
     * @return HasOne
     */
    public function type()
    {
        return $this->hasOne(CreditCardType::class, 'id', 'credit_card_type_id');
    }
}
