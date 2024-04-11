<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);

        // 1|i2a5Oi1Y6bH0FX2OIeANsu6uCHaCFXjtojGgVYPxea732694 -- jin 4|GWhJ2WwBtOvPJAZFwcFdolnRV6ph6vRCJ4UM0wlB9a0dc7da
        // 7|GANTvJnlZN1xA2XK9iQApuqc8zQUvt7OsycBH8ybe000746d jun 14|sfqCir378L165otKBYeY4qUjPSoYuztBkhuelQXwd143f4fc

    }

    public function logout(Request $request)
    {
        $user = $request->user(); // Get authenticated user

        if ($user) {
            $user->tokens()->delete(); // Delete all user's tokens
        }

        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK);
    }

    
}
