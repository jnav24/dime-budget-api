<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\Models\UserDevice
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property string $agent
 * @property string $verify_secret
 * @property string $verify_token
 * @property string|null $verified_at
 * @property string|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDevice query()
 * @mixin \Eloquent
 */
class UserDevice extends Model
{
    /**
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Table Name
     *
     * @var string
     */
    protected $table = 'user_devices';

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public static function getRequestedDevice(Request $request, $id)
    {
        return (new static())
            ->where('user_id', $id)
            ->where('ip', $request->ip())
            ->where('agent', $request->header('User-Agent'))
            ->first();
    }
}