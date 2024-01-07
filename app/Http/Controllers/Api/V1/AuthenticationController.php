<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function signIn(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json("Invalid credentials.", 401);
        }

        $user = Auth::user();

        $token = $user->createToken("$user->type-token", [$user->type]);

        return response()->json(['token' => $token->plainTextToken]);
    }

    public function signOut(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'status' => 'ok',
            'message' => 'Successfully logged out',
        ]);
    }
}
