<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Mail\RegisterUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    
    public function login(RegisterUserRequest $request) {

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

}
