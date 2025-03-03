<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function register(RegisterRequest $request) 
    {
        $registeredUser = User::create(
            [
                'name' => $request->name,
                'nickname' => $request->nickname,
                'email' => $request->email,
                'password' => $request->password,
            ]
        );
        $token = $registeredUser->createToken('auth_token')->plainTextToken;
        return ['token' => $token, 'user' => new UserResource($registeredUser)];
    }


    public function login(loginRequest $request) {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('auth_token')->plainTextToken;
            return ['token' => $token, 'user' => new UserResource(auth()->user())];
        }
        return response()->json(['error' => 'Epasts vai parole ir nepareiza!'], 401);
    }
}
