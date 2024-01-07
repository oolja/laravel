<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthenticationController extends Controller
{
    public function signIn(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json("Invalid credentials.", 401);
        }

        $user = Auth::user();

        if (is_null($user)) {
            throw new NotFoundHttpException('User not found');
        }

        $token = $user->createToken("$user->type-token", [$user->type]);

        return response()->json(['token' => $token->plainTextToken]);
    }

    public function signOut(): JsonResponse
    {
        Auth::user()?->tokens()->delete();
        return response()->json([
            'status' => 'ok',
            'message' => 'Successfully logged out',
        ]);
    }
}
