<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    // login Function
    // In Postman
    // form-data {
    //  email ->
    //  password ->
    // }
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }
        $user = User::where('email', $request->email)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of' . $user->name)->plainTextToken,
        ]);
    }

    // login Function
    // In Postman
    // form-data {
    // name ->
    // email ->
    // phone ->
    // address ->
    // password ->
    // password_confirmation ->
    // }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:8', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'min:10'],
            'address' => ['required'],
            'password' => ['required', 'min:8', 'confirmed:password'],

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of' . $user->name)->plainTextToken
        ]);
    }
}
