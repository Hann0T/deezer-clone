<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (
            $user &&
            Hash::check($request->password, $user->password)
        ) {
            $user->tokens()->delete();
            return response()->json([
                "token" => $user->createToken('auth-token')->plainTextToken,
            ]);
        }

        return response()->json([
            "message" => "Invalid credentials"
        ])->setStatusCode(422);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::make($request->validated());
        $country = Country::where('name', $request->validated()['country'])->first()->id;
        $user->country_id = $country;
        $user->save();

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('auth-token')->plainTextToken,
        ])->setStatusCode(202);
    }

    public function logout(Request $request)
    {
        $code = $request->user()->tokens()->delete();

        if ($code != 1) {
            return response()->json([
                "message" => "Something went wrong"
            ])->setStatusCode(500);
        }

        return response()->json([
            "message" => "Successful logout"
        ])->setStatusCode(200);
    }
}
