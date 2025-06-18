<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * @return ResourceCollection
     */
    public function index(): ResourceCollection {
        if (request()->page) {
            return UserResource::collection(User::paginate((request()->pagination) ?? 10));
        }
        return UserResource::collection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @param UserRequest $request
     * @return UserResource
     */
    public function store(UserRequest $request): UserResource {
        $validated = $request->validated();
        $user = User::create($validated);
        return new UserResource($user);
    }

    /**
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    public function update(Request $request){
        $user = auth()->user();

        try {
            // Validate request
            $validated = $request->validate([
                'username' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id, // Allow user's own email
            ]);

            // Update user
            $user->update($validated);

            return new UserResource($user);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422); // Return JSON errors instead of redirecting
        }
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse {
        $authUser = auth()->user();
        if($authUser->id == 1) {
            $user->delete();
        }

        return response()->json([
            'data' => [
                'message' => 'Ieraksts veiksmīgi dzēsts!',
            ],
        ], 204);
    }
}
