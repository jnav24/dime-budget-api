<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BudgetAggregation
 *
 * @property int $id
 * @property int $user_id
 * @property int $budget_id
 * @property string $type
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BudgetAggregation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BudgetAggregation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BudgetAggregation query()
 * @mixin \Eloquent
 */
class BudgetAggregation extends Model
{
    /**
     * Mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'budget_id',
        'type',
        'user_id',
        'value',
    ];

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'budget_aggregation';

    /**
     * Hide columns
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
