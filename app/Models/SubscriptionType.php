<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubscriptionType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionType query()
 * @mixin \Eloquent
 */
class SubscriptionType extends Model
{
    protected $table = 'subscription_types';

    protected $hidden= [
        'created_at',
        'updated_at',
    ];
}
