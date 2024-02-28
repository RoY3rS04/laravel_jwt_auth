<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Rules\AuthPasswordRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();

        $user = Auth::user();

        User::where('email', '=', $user->email)
            ->update($request->safe()->only(['name', 'email']));   
            
        $user->refresh();

        return response()->json([
            'ok' => true,
            'msg' => 'User updated correctly',
            'user' => $user
        ]);
    }

    public function changePassword(ChangePasswordRequest $request) {

        $data = $request->validated();

        $user = Auth::user();

        $user->password = Hash::make($data['password_new']);

        $user->save();

        return response()->json([
            'ok' => true,
            'msg' => 'Password changed correctly'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'max:255', new AuthPasswordRule]
        ]);

        $user = Auth::user();

        Auth::logout();

        $user->delete();

        return response()->json([
            'ok' => true,
            'msg' => 'User deleted correctly'
        ]);
    }
}
