<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Account\AccountResource;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * Respond with success.
     *
     * @return JsonResponse
     */
    protected function respondSuccess($message)
    {
        return $this->respond($message, 200);
    }

    /**
     * Return generic json response with the given data.
     *
     * @param $data
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function respond($data, $statusCode = 200, $headers = [])
    {
        return response()->json($data, $statusCode, $headers);
    }

    /**
     * Respond with created.
     *
     * @param $data
     * @return JsonResponse
     */
    protected function respondCreated($data)
    {
        return $this->respond($data, 201);
    }

    /**
     * Respond with no content.
     *
     * @return JsonResponse
     */
    protected function respondNoContent()
    {
        return $this->respond(null, 204);
    }

    /**
     * Respond with unauthorized.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->respondError($message, 401);
    }

    /**
     * Respond with error.
     *
     * @param $message
     * @param $statusCode
     * @return JsonResponse
     */
    protected function respondError($message, $statusCode)
    {
        return $this->respond(['success' => false,
            'message' => $message,
            'data' => [
                $message
            ]
        ], $statusCode);
    }

    /**
     * Respond with forbidden.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function respondForbidden($message = 'Forbidden')
    {
        return $this->respondError($message, 403);
    }

    /**
     * Respond with Not found.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function respondNotFound($message = 'Not found')
    {
        return $this->respondError($message, 404);
    }

    /**
     * Respond with failed login.
     *
     * @return JsonResponse
     */
    protected function respondFailedLogin($locale = null)
    {
        return $this->respondError(trans('messages.email_or_password_is_invalid', [], $locale), 422);
    }

    /**
     * Respond with internal error.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->respondError($message, 500);
    }

    /**
     * Get the token array structure.
     *
     * @param $tokenResult
     * @param null $user
     * @return JsonResponse
     */
    protected function respondWithToken($tokenResult)
    {
        return $this->respond([
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'expired_at' => $tokenResult->accessToken->expired_at,
            'account' => new AccountResource(auth()->user()->account)
        ]);
    }
}
