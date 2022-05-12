<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticationRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    public function login(AuthenticationRequest $request) :JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $token = Auth('api')->attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth('api')->user();

        return response()->json([
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], Response::HTTP_OK);
    }

    public function logout() :JsonResponse
    {
        Auth('api')->logout();

        return response()->json([
            'message' => 'Successfully logged out',
        ], Response::HTTP_OK);
    }

}
