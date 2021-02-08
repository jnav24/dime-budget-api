<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Budget
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $budget_cycle
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BudgetAggregation[] $aggregations
 * @property-read int|null $aggregations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bank[] $banks
 * @property-read int|null $banks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Childcare[] $childcare
 * @property-read int|null $childcare_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CreditCard[] $credit_cards
 * @property-read int|null $credit_cards_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Education[] $education
 * @property-read int|null $education_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Entertainment[] $entertainment
 * @property-read int|null $entertainment_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Food[] $food
 * @property-read int|null $food_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Gift[] $gift
 * @property-read int|null $gift_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Housing[] $housing
 * @property-read int|null $housing_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Income[] $incomes
 * @property-read int|null $incomes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Investment[] $investments
 * @property-read int|null $investments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Loan[] $loan
 * @property-read int|null $loan_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Medical[] $medical
 * @property-read int|null $medical_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Miscellaneous[] $miscellaneous
 * @property-read int|null $miscellaneous_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Personal[] $personal
 * @property-read int|null $personal_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shopping[] $shopping
 * @property-read int|null $shopping_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscription
 * @property-read int|null $subscription_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tax[] $tax
 * @property-read int|null $tax_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Travel[] $travel
 * @property-read int|null $travel_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Utility[] $utilities
 * @property-read int|null $utilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vehicle[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Budget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Budget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Budget query()
 * @mixin \Eloquent
 */
class Budget extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'budget_cycle',
        'user_id',
    ];

    /**
     * Hide columns
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Aggregations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aggregations()
    {
        return $this->hasMany(BudgetAggregation::class, 'budget_id', 'id');
    }

    /**
     * Banks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function banks()
    {
        return $this->hasMany(Bank::class, 'budget_id', 'id');
    }

    /**
     * Childcare
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childcare()
    {
        return $this->hasMany(Childcare::class, 'budget_id', 'id');
    }

    /**
     * Credit Card
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credit_cards()
    {
        return $this->hasMany(CreditCard::class, 'budget_id', 'id');
    }

    /**
     * Education
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function education()
    {
        return $this->hasMany(Education::class, 'budget_id', 'id');
    }

    /**
     * Entertainment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entertainment()
    {
        return $this->hasMany(Entertainment::class, 'budget_id', 'id');
    }

    /**
     * Food
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function food()
    {
        return $this->hasMany(Food::class, 'budget_id', 'id');
    }

    /**
     * Gift
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gift()
    {
        return $this->hasMany(Gift::class, 'budget_id', 'id');
    }

    /**
     * Housing
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function housing()
    {
        return $this->hasMany(Housing::class, 'budget_id', 'id');
    }

    /**
     * Investments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function investments()
    {
        return $this->hasMany(Investment::class, 'budget_id', 'id');
    }

    /**
     * Jobs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomes()
    {
        return $this->hasMany(Income::class, 'budget_id', 'id');
    }

    /**
     * Loan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loan()
    {
        return $this->hasMany(Loan::class, 'budget_id', 'id');
    }

    /**
     * Personal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personal()
    {
        return $this->hasMany(Personal::class, 'budget_id', 'id');
    }

    /**
     * Shopping
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shopping()
    {
        return $this->hasMany(Shopping::class, 'budget_id', 'id');
    }

    /**
     * Subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscription()
    {
        return $this->hasMany(Subscription::class, 'budget_id', 'id');
    }

    /**
     * Tax
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tax()
    {
        return $this->hasMany(Tax::class, 'budget_id', 'id');
    }

    /**
     * Travel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function travel()
    {
        return $this->hasMany(Travel::class, 'budget_id', 'id');
    }

    /**
     * Medical
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medical()
    {
        return $this->hasMany(Medical::class, 'budget_id', 'id');
    }

    /**
     * Miscellaneous
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function miscellaneous()
    {
        return $this->hasMany(Miscellaneous::class, 'budget_id', 'id');
    }

    /**
     * Utilities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function utilities()
    {
        return $this->hasMany(Utility::class, 'budget_id', 'id');
    }

    /**
     * Vehicles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'budget_id', 'id');
    }
}
