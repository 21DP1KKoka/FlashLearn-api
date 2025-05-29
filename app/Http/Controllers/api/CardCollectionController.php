<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardCollectionRequest;
use App\Http\Resources\CardCollectionResource;
use App\Http\Resources\CardCollectionStatsResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\CardCollection;
use Illuminate\Http\JsonResponse;

class CardCollectionController extends Controller
{
    /**
     * @return ResourceCollection
     */
    public function index(): ResourceCollection {
        $user = auth()->user();
        if (request()->page) {
            return CardCollectionResource::collection(CardCollection::where("user_id", $user->id)->paginate((request()->pagination) ?? 10)->orderBy("id", "DESC")->get());
        }
        return CardCollectionResource::collection(CardCollection::where("user_id", $user->id)->orderBy("id", "DESC")->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @param CardCollectionRequest $request
     * @return CardCollectionResource
     */
    public function store(CardCollectionRequest $request): CardCollectionResource {
//        $user = auth()->user();
//        $validated = $request->validated();
//        $cardCollection = CardCollection::create($validated);
//        dd($cardCollection);
        /** @var User $user */
        $user = auth()->user();
        $validated = $request->validated();
        $cardCollection = $user->cardCollections()->create($validated);
//        $cardCollection = CardCollection::create($validated);
        return new CardCollectionResource($cardCollection);
    }

    /**
     * @param CardCollection $cardCollection
     * @return CardCollectionResource
     */
    public function show(CardCollection $cardCollection): CardCollectionResource {
        return new CardCollectionResource($cardCollection);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CardCollection $cardCollection)
    {
        //
    }

    /**
     * @param CardCollectionRequest $request
     * @param CardCollection $cardCollection
     * @return CardCollectionResource
     */
    public function update(CardCollectionRequest $request, CardCollection $cardCollection): CardCollectionResource {
        $validated = $request->validated();
        $cardCollection->update($validated);
        return new CardCollectionResource($cardCollection);
    }

    /**
     * @param CardCollection $cardCollection
     * @return JsonResponse
     */
    public function destroy(CardCollection $cardCollection): JsonResponse {
        $cardCollection->delete();
        return response()->json([
            'data' => [
                'message' => 'Ieraksts veiksmīgi dzēsts!',
            ],
        ], 204);
    }
}
