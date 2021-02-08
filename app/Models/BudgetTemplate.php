<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BudgetTemplate
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BankTemplate[] $banks
 * @property-read int|null $banks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChildcareTemplate[] $childcare
 * @property-read int|null $childcare_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CreditCardTemplate[] $credit_cards
 * @property-read int|null $credit_cards_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EducationTemplate[] $education
 * @property-read int|null $education_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EntertainmentTemplate[] $entertainment
 * @property-read int|null $entertainment_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FoodTemplate[] $food
 * @property-read int|null $food_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\GiftTemplate[] $gift
 * @property-read int|null $gift_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\HousingTemplate[] $housing
 * @property-read int|null $housing_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\IncomeTemplate[] $incomes
 * @property-read int|null $incomes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvestmentTemplate[] $investments
 * @property-read int|null $investments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LoanTemplate[] $loan
 * @property-read int|null $loan_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MedicalTemplate[] $medical
 * @property-read int|null $medical_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MiscellaneousTemplate[] $miscellaneous
 * @property-read int|null $miscellaneous_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PersonalTemplate[] $personal
 * @property-read int|null $personal_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShoppingTemplate[] $shopping
 * @property-read int|null $shopping_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SubscriptionTemplate[] $subscription
 * @property-read int|null $subscription_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TaxTemplate[] $tax
 * @property-read int|null $tax_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TravelTemplate[] $travel
 * @property-read int|null $travel_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UtilityTemplate[] $utilities
 * @property-read int|null $utilities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\VehicleTemplate[] $vehicles
 * @property-read int|null $vehicles_count
 * @method static \Illuminate\Database\Eloquent\Builder|BudgetTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BudgetTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BudgetTemplate query()
 * @mixin \Eloquent
 */
class BudgetTemplate extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'budget_templates';

    /**
     * Bank Template
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function banks()
    {
        return $this->hasMany(BankTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Childcare
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childcare()
    {
        return $this->hasMany(ChildcareTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Credit Card Template
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function credit_cards()
    {
        return $this->hasMany(CreditCardTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Education
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function education()
    {
        return $this->hasMany(EducationTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Entertainment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entertainment()
    {
        return $this->hasMany(EntertainmentTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Food
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function food()
    {
        return $this->hasMany(FoodTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Gift
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gift()
    {
        return $this->hasMany(GiftTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Housing
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function housing()
    {
        return $this->hasMany(HousingTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Investment Template
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function investments()
    {
        return $this->hasMany(InvestmentTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Jobs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomes()
    {
        return $this->hasMany(IncomeTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Loan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loan()
    {
        return $this->hasMany(LoanTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Personal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personal()
    {
        return $this->hasMany(PersonalTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Shopping
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shopping()
    {
        return $this->hasMany(ShoppingTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscription()
    {
        return $this->hasMany(SubscriptionTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Tax
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tax()
    {
        return $this->hasMany(TaxTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Travel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function travel()
    {
        return $this->hasMany(TravelTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Medical Template
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medical()
    {
        return $this->hasMany(MedicalTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Miscellaneous Template
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function miscellaneous()
    {
        return $this->hasMany(MiscellaneousTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Utilities Template
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function utilities()
    {
        return $this->hasMany(UtilityTemplate::class, 'budget_template_id', 'id');
    }

    /**
     * Vehicles Template
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehicles()
    {
        return $this->hasMany(VehicleTemplate::class, 'budget_template_id', 'id');
    }
}
