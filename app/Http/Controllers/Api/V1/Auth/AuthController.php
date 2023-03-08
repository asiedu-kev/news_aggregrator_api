<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Account\AccountResource;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

/**
 * @group Auth management
 *
 * APIs for managing auth
 */
class AuthController extends ApiController
{
    public $email;

    /**
     * Login
     * @group Auth management
     * @unauthenticated
     *
     * @bodyParam  email string required The email of the user Example:  user@testourvoice.com
     * @bodyParam password string required Password of the user  Example:  motDePasse
     *
     * @response scenario=success status=200 {
     *  "access_token": "2|qmNXH0cbgMNkBbeW47orzYE5dC9aQKbgbTp3ZSf96JcOMOSlTKAYToswIVveWzdxQtgpj* YJFAkoYeywhQMG5LiRjXkDQgakPVjATPWWwfeX8H72wDbq2IwueUYnHYpTQ9htpYcy7j8fmVaVnqc83DYTfRxqxA3qrw
     * OUWOCmBvja6hcTUOoa5c0bZEmo7XCYL0eiykSVOVYvKs37gRJq6B27Xvh",
     *  "token_type": "Bearer",
     *  "expired_at" : "2023-02-08T19:49:08.000000Z"
     * }
     *
     * @response scenario=failed status=400 {
     *  "message": "Email or Password is invalid"
     * }
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $validatedData = $request->all();
        $locale = $request->getLocale();
        if (!auth()->attempt($validatedData)) {
            return $this->respondFailedLogin($locale);
        }
        $user = auth()->user();
        if ($user->account == null && $user->email_verified_at == null) {
            return $this->respondError('Your email address is not verified.', 403);
        }
        $tokenResult = auth()->user()->createToken(Str::random(15));
        return $this->respondWithToken($tokenResult);
    }

    /**
     * Register
     *
     * @unauthenticated
     * @group Auth management
     *
     * @bodyParam first_name string required The first name of the user Example:  John
     * @bodyParam last_name string required The last_name of the user Example : Doe
     * @bodyParam email string required Email of the user  Example:  test@ourvoice.com
     * @bodyParam password  string required Password of the user Example : 12345678
     * @bodyParam phone  string required Phone of the user Example : 22961616161
     *
     * @return JsonResponse
     *
     *
     */

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if (!empty($user)) {
            $user->save();
            // create the associated account
            $account = Account::create([
                "owner_id" => $user->id,
                "name" => 'Account_' . $user->email,
                "timezone" => "",
                "country" => $request->country,
                "locale" => $request->local ?? 'en'
            ]);
            $tokenResult = $user->createToken(Str::random(15));

            // TODO Send email verification to the user
            // Return the API Token
            return response()->json([
                'success' => true,
                'message' => trans('messages.successfully_operated', [], $user->locale),
                'data' => [
                    "token" => $tokenResult->plainTextToken,
                    "account" => new AccountResource($account)
                ]
            ], 201);
        }
        return $this->respondError(trans('messages.user_not_created', [], $request->getLocale()), 500);
    }

    /**
     * Logout
     *
     * @authenticated
     * @group Auth management
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(null, 204);
    }
}
