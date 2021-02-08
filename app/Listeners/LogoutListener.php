<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cookie;

class LogoutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Logout $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $tokenId = request()->bearerToken();
        $user = $event->user;

        if (!empty($user) && !empty($tokenId)) {
            Cookie::queue(Cookie::forget(env('COOKIE_NAME', 'access_token')));
            $user->tokens()->where('id', $tokenId)->delete();
        }
    }
}
