<?php

namespace App\Http\Controllers\api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return AuthResource
     */
    public function register(RegisterRequest $request): AuthResource {
        $validated = $request->validated();
        $user = User::create($validated);
        $token = $user->createToken('authToken')->plainTextToken;
        return new AuthResource([
            'user' => $user,
            'token' => $token,
        ]);
    }


    public function login(loginRequest $request): AuthResource {
        $validated = $request->validated();
        if (!auth()->attempt($validated)) {
            throw new ApiException('Nepareizi pieslēgšanās dati.', 401);
        }
        $user = auth()->user();
        $token = $user->createToken('authToken')->plainTextToken;
        return new AuthResource([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json(null, 200);
    }

    /**
     * @return UserResource
     */
    public function user(): UserResource {
        return new UserResource(Auth::user());
    }
}
