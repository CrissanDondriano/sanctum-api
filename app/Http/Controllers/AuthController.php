<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ], //custom validation error messages for password, email, and name 
        [
            'email.unique' => 'The email has already been taken.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ]);

        // create a new user using the User model
        // User::create is pre-defined method in Laravel to create a new user by passing the request data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // hash the password before storing it in the database
        ]);

        // a message that returns when the user is successfully registered
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    /**
     * Authenticate a user and generate token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // validate is predefine method in Laravel to validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // the Auth::attempt is pre-defined method in Laravel to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json(['token' => $token], 201);
        }

        // Authentication failed
        return response()->json(['message' => 'Invalid username or password'], 401);
    }
}
