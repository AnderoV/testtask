<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Authcontroller extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $kasutaja = User::where('email', $credentials['email'])->first();
        if (!$kasutaja || !Hash::check($credentials['password'], $kasutaja->password)) {
            return response()->json(['sõnum' => 'Vale e-post või parool'], 401);
        }

        $token = $kasutaja->createToken('api-token')->plainTextToken;

        return response()->json([
            'kasutaja' => $kasutaja->only(['id', 'name', 'email']),
            'token' => $token,
        ]);
    }
}