<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MedicalTemplate
 *
 * @property int $id
 * @property int $budget_template_id
 * @property string $name
 * @property string $amount
 * @property int $due_date
 * @property int $medical_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicalTemplate query()
 * @mixin \Eloquent
 */
class MedicalTemplate extends Model
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
        'medical_type_id' => null,
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
        'medical_type_id',
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
    protected $table = 'medical_templates';
}
