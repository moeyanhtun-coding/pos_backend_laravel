<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator as confirm;

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
        $validator =
            Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8'],
            ]);

        if ($validator->fails()) {
            return $this->error(
                '',
                $validator->errors()->all(),
                422
            );
        }


        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return $this->success(
                    [
                        'user' => $user,
                        'token' => $user->createToken(time())->plainTextToken
                    ],
                    'Login Success',
                    200
                );
            }
        }
        return $this->error(
            '',
            'Credentials Do Not Match',
            '401'
        );
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:8', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'min:10'],
            'address' => ['required'],
            'password' => ['required', 'min:8', 'confirmed:password'],

        ]);
        if ($validator->fails()) {
            return $this->error(
                "",
                $validator->errors()->all(),
                422
            );
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken(time())->plainTextToken,
        ]);
    }
}
