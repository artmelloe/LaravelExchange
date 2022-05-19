<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\AuthenticationRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    /**
    * @OA\Post(
    *      path="/login",
    *      tags={"Authentication"},
    *      summary="User login",
    *      operationId="login",
    *      @OA\Parameter(
    *          name="email",
    *          in="query",
    *          required=true,
    *          example="admin@admin.com",
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Parameter(
    *          name="password",
    *          in="query",
    *          required=true,
    *          example="admin",
    *          @OA\Schema(
    *              type="string"
    *          )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Success"
    *      ),
    *       @OA\Response(
    *          response=401,
    *          description="Unauthorized"
    *      ),
    *       @OA\Response(
    *          response=422,
    *          description="Unprocessable Content"
    *      )
    * )
    */

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

    /**
    * @OA\Get(
    *     path="/logout",
    *     tags={"Authentication"},
    *     summary="User logout",
    *     operationId="logout",
    *      security={
    *          {"bearer": {}}
    *      },
    *     @OA\Response(
    *         response=200,
    *         description="Success"
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Internal Server Error"
    *     ),
    * )
    */

    public function logout() :JsonResponse
    {
        Auth('api')->logout();

        return response()->json([
            'message' => 'Successfully logged out',
        ], Response::HTTP_OK);
    }

}
