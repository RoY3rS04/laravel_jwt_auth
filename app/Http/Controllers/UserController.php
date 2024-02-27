<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
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

        if(!Hash::check($data['password'], $user->password)) {
            return response()->json([
                'ok' => false,
                'msg' => 'Incorrect password'
            ], 400);
        }

        $updatedUser = User::where('email', '=', $user->email)
            ->update($request->safe()->only(['name', 'email']))
            ->get();        

        return response()->json([
            'ok' => true,
            'msg' => 'User updated correctly',
            'user' => $updatedUser
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
