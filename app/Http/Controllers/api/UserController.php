<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

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

    /**
     * @param UserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserRequest $request, User $user): UserResource {
        $validated = $request->validated();
        $user->update($validated);
        return new UserResource($user);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse {
        $user->delete();
        return response()->json([
            'data' => [
                'message' => 'Ieraksts veiksmīgi dzēsts!',
            ],
        ], 204);
    }
}
