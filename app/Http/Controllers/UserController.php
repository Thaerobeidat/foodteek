<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register (Request $request) {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:users,email',
            'date_of_birth' => 'required|date',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'date_of_birth'=>$request->date_of_birth,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password)

        ]);
        return response()->json([
            'message'=>'User Registered Successfully',
            'User'=>$user],201);
    }
    public function login(Request$request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',

        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }
        
        $user =User::where('email',$request->email)->firstOrFail();
        $token = $user->createToken('auth_Token')->plainTextToken;
        return response()->json([
            'message'=>'User Login Successfully',
            'User'=>$user,
            'Token'=>$token
        ],200);
    }

    public function logout (Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>'logout successfull']);
    }
}
