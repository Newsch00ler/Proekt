<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                $token = $user->createToken('AppName')->accessToken;
                return response()->json(['token' => $token], 200);
            }

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
