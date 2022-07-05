<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Post(
 * path="api/v1/user/login",
 * summary="User Login",
 * description="Authenticate to get API Key for the rest of the protected end points",
 * operationId="userLogin",
 * tags={"Auth"},
 * security={ {"bearer": {} }},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass game with title and description",
 *    @OA\JsonContent(
 *       required={"title","description"},
 *       @OA\Property(property="title", type="string", format="text", example="Steam"),
 *       @OA\Property(property="description", type="string", format="text", example="A cross platform gaming system.")
 *    ),
 * ),
 * @OA\Response(
 *    response=200,
 *    description="Success",
 *    @OA\JsonContent(
 *       @OA\Property(property="access_token", type="string", example="1|4qrnKW3yDVl6UsvjeyqE9oFWr2sDhnRTcN2KZlnn"),
 *       @OA\Property(property="token_type", type="string", example="Bearer")
 *        )
 *     ),
 * @OA\Response(
 *    response=401,
 *    description="Failed, missing merchant profile",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Invalid login details")
 *        )
 *     )
 * )
 *
 */

class AuthController extends Controller
{

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        try {
            $user = User::where('email', $request['email'])
                ->where('active', 1)
                ->firstOrFail();
        }catch(\Exception $e){
//            dd( $e->getMessage())
            return response()->json(['message' => 'User is not active'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
