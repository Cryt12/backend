<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    //login
    public function login(UserRequest $request)
    {
        $request->validate([

        ]);
     
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $response = [
            'user'      =>  $user,
            'token'     =>  $user->createToken($request->email)->plainTextToken
        ];
     
        return $response;
    } 

    //logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        $response =[
            'message' => 'Logout'
        ];

        return $response;
    }
}
