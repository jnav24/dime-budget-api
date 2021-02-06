<?php

namespace App\Http\Middleware;

use App\Traits\APIResponse;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class VerifyApiSession
{
    use APIResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenId = $request->bearerToken();
        $user = auth()->user();

        if (empty($user) || empty($tokenId)) {
            return $this->respondWithForbidden();
        }

        $token = $user->tokens()->where('id', $tokenId)->first();

        if (empty($token)) {
            return $this->respondWithForbidden();
        }

        $now = Carbon::now();
        $then = Carbon::createFromTimeString($token->created_at);
        $expired = $now->diffInMinutes($then) > (int) env('SESSION_LIFETIME', 120);

        if (empty($user->getRememberToken()) && $expired) {
            $token->delete();
            return $this->respondWithForbidden();
        }

        return $next($request);
    }
}
