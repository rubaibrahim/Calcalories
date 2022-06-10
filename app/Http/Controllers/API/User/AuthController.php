<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Base\ApiController;
use App\Models\User\User;
use App\Models\User\UserDetails;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends ApiController
{
    const singleResultName = "user";


    public function register(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'email' => ['required', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:20'],
        ]);
        if ($validator->fails() == true)
            return $this->responseValidatorObject($validator->errors());

        // add user data
        $record = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        if ($record->exists) {
            // add default user details data
            UserDetails::create([
                "user_id" => $record->id,
                'date_of_birth' => '2004-01-01', // date('Y-m-d'),
            ]);

            // login to git token with response
            return $this->login($request);
        }

        return $this->responseErrorCanNotSaveData();
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = [
            'email' => $request->get("email"),
            'password' => $request['password']
        ];;

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255','exists:users,email'],
            'password' => ['required', 'string', 'min:6', function ($attribute, $value, $fail) use ($credentials) {
                if (!Auth::attempt($credentials)) {
                    return $fail(__('The provided password is incorrect.'));
                }
                return true;
            }],
        ]);
        if ($validator->fails())
            return $this->responseValidatorObject($validator->errors());



        if (Auth::attempt($credentials) == true) {

            $user_id = Auth::user()->id;

            $user = UserController::getUserData($user_id);

//            // Revoke all tokens...
           $user->tokens()->delete();
            // Create access token
            $user->token = $user->createToken("Personal Access Token")->plainTextToken;

            return $this->getResponse(self::singleResultName, $user);
        }
        return $this->responseErrorMessage(trans('These credentials do not match our records'));
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user() != null) {
            $user_id = $request->user()->id;

            // Delete fcm token
            User::where('id', $user_id)->update(['fcm_token' => null]);

            // Delete any token you have
            // delete from oauth_access_tokens where tokenable_id = $user_id
            //DB::table('oauth_access_tokens')->where('tokenable_id', $user_id)->delete();
            $request->user()->tokens()->delete();

            return $this->responseSuccessMessage();
        }
        return $this->responseUnauthorized();
    }
}
