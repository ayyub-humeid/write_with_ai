<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AccessTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device' => ['nullable', 'string'],
        ]);

        $user = User::query()
            ->where('email', '=', $request->post('email'))
            ->first();

        if (!$user || !Hash::check($request->post('password'), $user->password)) {
            return Response::json([
                'status' => 'unauthenticated',
                'message' => 'Invalid email or password',
            ], 401);
        }

        $token = $user->createToken(
            $request->post('device', $request->userAgent()),
            ['posts.create', 'posts.update', 'posts.delete'],
            now()->addDays(30),
        );

        return Response::json([
            'token' => $token->plainTextToken,
            'user' => $user,
        ], 201);
    }

    public function destroy($token = null)
    {

        $user = Auth::guard('sanctum')->user();

        if (!$token) {
            $user->currentAccessToken()->delete();
            return Response::noContent();
        }

        if ($token == 'all') {
            $user->tokens()->delete();
            return Response::noContent();
        }

        $token = Sanctum::personalAccessTokenModel()::findToken($token);
        if (
            $token->tokenable_id == $user->id
            && $token->tokenable_type == $user::class
        ) {
            $token->delete();
        }
        return Response::noContent();
    }
}
