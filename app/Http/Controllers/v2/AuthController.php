<?php

namespace App\Http\Controllers\v2;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller\v2;

class AuthController extends Controller
{
    public function auth(LoginRequest $request)
    {
        $input = $request->validated();

        $credentials = [
            'email' => $input['login'],
            'password' => $input['password'],
        ];

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'token' => 'JWT',
            'user' => [
                'login' => auth()->user()->email,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL()
            ]
        ]);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

}
