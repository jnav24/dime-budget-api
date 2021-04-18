<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\UserVehicle;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();
            $verifyList = [];
            // @todo figure out if i want to keep this code or not
//            $device = UserDevice::getRequestedDevice($this->request, $user->id);

//            if (empty($device)) {
//                $device = $this->setUserDeviceRecord($user->id);
//            }

//            if ($this->isNotValidDevice($device)) {
//                $verifyList = [
//                    'token' => $device->verify_token,
//                ];
//            }

            $userProfile = UserProfile::where('user_id', $user->id)->first()->toArray();
            $vehicles = UserVehicle::where('user_id', $user->id)->get()->toArray();

            return $this->respondWithOK([
                'user' => [
                        'mfa_enabled' => !empty($user->two_factor_secret),
                        'email' => $user->email,
                    ] + $userProfile,
                'vehicles' => $vehicles,
                'verify' => $verifyList,
            ]);
        } catch(\Exception $e) {
            Log::debug('AuthController::currentUser - ' . $e->getMessage());
            return $this->respondWithBadRequest([], 'Something unexpected has occurred');
        }
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function updateUserProfile(Request $request)
    {
        try {
            $request->validate([
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
        return $this->respondWithOK([
            'exp' => env('SESSION_LIFETIME', 120),
            'token' => $token->plainTextToken,
        ]);
    }
}
