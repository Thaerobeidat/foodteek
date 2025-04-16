<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdateProfileRequest;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // Creating the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User Registered Successfully',
            'User' => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        // Attempt to log the user in
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        // Retrieve the user by email and generate the token
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_Token')->plainTextToken;

        return response()->json([
            'message' => 'User Login Successfully',
            'User' => $user,
            'Token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        // Logout the user by deleting the current token
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
{
    // Retrieve validated data from the request
    $data = $request->validated();

    // Retrieve the user by email
    $user = User::where('email', $data['email'])->first();

    // Check if the user exists
    if (!$user) {
        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

    // Assign the new password directly (will be hashed automatically)
    $user->password = $data['password'];
    $user->save();

    return response()->json([
        'message' => 'Password reset successful'
    ], 200);
}

public function updateProfile(UpdateProfileRequest $request)
{
    $user = auth()->user();

    $user->update($request->validated());

    return response()->json([
        'message' => 'Profile updated successfully.',
        'user' => $user
    ]);
}




}
