<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validate Form Inputs Before Registering User
        $inputs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        // Create User
        $user = User::create([
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => Hash::make($inputs['password'])
        ]);

        // Create User Token
        $token = $user->createToken('myapptoken')->plainTextToken;

        // Response
        $response = [
            'user' => $user,
            'token' => $token
        ];

        // Return Response With Created Message
        return response($response, 201);
    }

    public function login(Request $request)
    {
        // Validate Form Inputs Before Logging in User
        $inputs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Check Email
        $user = User::where('email', $inputs['email'])->first();

        // Check Password
        if(!$user || !Hash::check($inputs['password'], $user->password))
        {
            return response([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Create User Token
        $token = $user->createToken('myapptoken')->plainTextToken;

        // Response
        $response = [
            'user' => $user,
            'token' => $token
        ];

        // Return Response With Created Message
        return response($response, 201);
    }

    // Logout User And Destroy Token
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out successfully'
        ];
    }
}
