<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Bank
 *
 * @property int $id
 * @property string $name
 * @property string $amount
 * @property int $bank_type_id
 * @property int $budget_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $bank_template_id
 * @property-read \App\Models\BankType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank query()
 * @mixin \Eloquent
 */
class Bank extends Model
{
    /**
     * Default Attributes
     * bank_template_id gets the latest bank amount from bank template and saves it to the bank on creation
     * also, when the latest bank is saved, update the budget template
     * @var array
     */
    protected $attributes = [
        'name' => null,
        'amount' => null,
        'bank_type_id' => null,
        'budget_id' => null,
        'bank_template_id' => null,
    ];

    /**
     * Mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'amount',
        'bank_type_id',
        'budget_id',
        'bank_template_id',
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
    protected $table = 'banks';

    /**
     * @return HasOne
     */
    public function type()
    {
        return $this->hasOne(BankType::class, 'id', 'bank_type_id');
    }
}
