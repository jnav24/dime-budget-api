<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\UserVehicle;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function updateUserProfile(Request $request)
    {
        try {
            $request->validate($request, [
                'profile' => 'required',
                'vehicles' => 'required|array'
            ]);

            $profileAttributes = ['first_name', 'last_name'];
            $profileRequest = array_intersect_key(
                $request->input('profile'),
                array_flip($profileAttributes)
            );

            if (empty($profileRequest) || count($profileAttributes) !== count($profileRequest)) {
                return $this->respondWithBadRequest([], '');
            }

            $profile = UserProfile::where('user_id', auth()->user()->id)->first();
            $profile->first_name = $profileRequest['first_name'];
            $profile->last_name = $profileRequest['last_name'];
            $profile->save();

            $attributes = (new UserVehicle())->getAttributes();

            $vehicles = array_map(function ($vehicle) use ($attributes) {
                return UserVehicle::updateOrCreate(
                    ['id' => $this->isNotTempId($vehicle['id']) ? $vehicle['id'] : null],
                    array_intersect_key(
                        $vehicle,
                        $attributes
                    )
                );
            }, $request->input('vehicles'));

            return $this->respondWithOK([
                'profile' => array_merge(
                    $profile->toArray(),
                    ['email' => auth()->user()->email]
                ),
                'vehicles' => $vehicles,
            ]);
        } catch(ValidationException $e) {
            return $this->respondWithBadRequest($e->errors(), 'Error validating request');
        } catch(\Exception $e) {
            Log::error('UserController::updateUserProfile - ' . $e->getMessage());
            return $this->respondWithBadRequest([], 'Unable to save user profile');
        }
    }

    public function setApiToken()
    {
        $user = auth()->user();

        if (empty($user)) {
            $this->respondWithUnauthorized();
        }

        $token = $user->createToken($user->email);
        Cookie::queue(Cookie::make(env('COOKIE_NAME', 'access_token'),  $token->plainTextToken, env('SESSION_LIFETIME', 120)));
        return $this->respondWithOK();
    }
}
