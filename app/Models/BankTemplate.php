<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BankTemplate
 *
 * @property int $id
 * @property string $name
 * @property string $amount
 * @property int $bank_type_id
 * @property int $budget_template_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BankTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankTemplate query()
 * @mixin \Eloquent
 */
class BankTemplate extends Model
{
    /**
     * Default Attributes
     *
     * @var array
     */
    protected $attributes = [
        'name' => null,
        'amount' => null,
        'bank_type_id' => null,
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
        'bank_type_id',
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
    protected $table = 'bank_templates';
}
