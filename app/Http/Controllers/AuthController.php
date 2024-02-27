<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Mail\RegisterUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    
    public function store(RegisterUserRequest $request) {

        $data = $request->validated();

        if ($data['password'] !== $data['password_confirm']) {
            return response()->json([
                'ok' => false,
                'msg' => 'Password and Confirm Password must be equals'
            ], 400);
        }

        $user = User::create([
            ...$request->safe()->only('name', 'email'),
            'password' => Hash::make($data['password'])
        ]);

        Mail::to($user)->send(new RegisterUser($user));

        return response()->json([
            'ok' => true,
            'msg' => 'An email with further instructions was sent to you'
        ]);
    }

    public function verifyEmail(Request $request) {

        try {
            $payload = Auth::payload();
        } catch (\Throwable $th) {
            
            return response()->json([
                'ok' => false,
                'msg' => 'Invalid or missing token'
            ], 400);

        }

        User::where('id', $payload['sub'])
            ->update(['email_verified_at' => now()]);

        Auth::invalidate();

        return response()->json([
            'ok' => true,
            'msg' => 'Email verified correctly'
        ]);
    }
    
    public function login(LoginRequest $request) {

        $data = $request->validated();

        $user = User::where('email', '=', $data['email'])
            ->firstOrFail();

        if($user->email_verified_at === null) {
            return response()->json([
                'ok' => false,
                'msg' => 'You must to verify your email first'
            ], 400);
        }

        if(!Hash::check($data['password'], $user->password)) {
            return response()->json([
                'ok' => false,
                'msg' => 'Incorrect password, please try again'
            ], 400);
        }

        $token = Auth::login($user);

        return response()->json([
            'ok' => true,
            'msg' => 'User logged in!',
            'token' => $token
        ]);
    }

    public function authUser(Request $request) {

        try {
            $user = Auth::userOrFail();
        } catch (\Throwable $th) {
            //todo bad response;
        }

        return response()->json([
            'ok' => true,
            'msg' => 'User retrieved correctly',
            'user' => $user
        ]);

    }

    public function logOut(Request $request) {

        Auth::logout();

        return response()->json([
            'ok' => true,
            'msg' => 'logged out correctly'
        ]);

    }

}
