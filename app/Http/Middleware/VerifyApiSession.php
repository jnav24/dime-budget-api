<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Laravel\Sanctum\PersonalAccessToken;

class VerifyApiSession
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenId = $request->bearerToken();
        $user = auth()->user();
        $this->verifyUserAndTokenId($user, $tokenId);
        $token = $user->tokens()->where('id', $tokenId)->first();
        $this->verifyToken($token);
        $this->verifyExpiration($user, $token);
        return $next($request);
    }

    /**
     * @param User $user
     * @param string $tokenId
     * @throws AuthenticationException
     */
    public function verifyUserAndTokenId(User $user, string $tokenId): void
    {
        if (empty($user) || empty($tokenId)) {
            throw new AuthenticationException();
        }
    }

    /**
     * @param PersonalAccessToken $token
     * @throws AuthenticationException
     */
    public function verifyToken(PersonalAccessToken $token): void
    {
        if (empty($token)) {
            throw new AuthenticationException();
        }
    }

    /**
     * @param User $user
     * @param PersonalAccessToken $token
     * @throws AuthenticationException
     */
    public function verifyExpiration(User $user, PersonalAccessToken $token): void
    {
        $now = Carbon::now();
        $then = Carbon::createFromTimeString($token->created_at);
        $expired = $now->diffInMinutes($then) > (int) env('SESSION_LIFETIME', 120);

        if (empty($user->getRememberToken()) && $expired) {
            $token->delete();
            Cookie::queue(Cookie::forget(env('COOKIE_NAME', 'access_token')));
            throw new AuthenticationException();
        }
    }
}
