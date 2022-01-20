<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $feilds = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $feilds['name'],
            'email' => $feilds['email'],
            'password' => bcrypt($feilds['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $respone = [
            'user' => $user,
            'token' => $token
        ];

        return response($respone, 201);
    }

    public function login(Request $request)
    {
        $feilds = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //email check
        $user = User::where('email', $feilds['email'])->first();

        //password check

        if (!$user || !Hash::check($feilds['password'], $user->password)) {
            return response([
                'message' => 'Bad Creds'
            ]);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $respone = [
            'user' => $user,
            'token' => $token
        ];

        return response($respone, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
