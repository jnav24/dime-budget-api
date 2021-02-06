<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Investment
 *
 * @property int $id
 * @property string $name
 * @property string $amount
 * @property int $investment_type_id
 * @property int $budget_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\InvestmentType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Investment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Investment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Investment query()
 * @mixin \Eloquent
 */
class Investment extends Model
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
        'investment_type_id',
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
    protected $table = 'investments';

    /**
     * @return HasOne
     */
    public function type()
    {
        return $this->hasOne(InvestmentType::class, 'id', 'investment_type_id');
    }
}
