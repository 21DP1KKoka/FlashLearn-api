<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardCollectionRequest;
use App\Http\Resources\CardCollectionResource;
use App\Http\Resources\CardCollectionStatsResource;
use App\Models\SharedCollection;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\CardCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\URL;

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

    public function getSharedCollections(): ResourceCollection {
        $user = auth()->user();
//        dd($user);
//        $sharedCollectionIds = SharedCollection::where('user_id', $user->id)->pluck("card_collection_id");
//        dd($sharedCollectionIds);

        $sharedCollectionIds = SharedCollection::where('user_id', $user->id)
            ->pluck('card_collection_id') // Ensure correct column reference
            ->toArray(); // Convert collection to array for safer querying

        $sharedCollections = CardCollection::whereIn('id', $sharedCollectionIds)->orderBy('id', 'DESC');
        if (request()->page) {
            return CardCollectionResource::collection($sharedCollections->paginate((request()->pagination) ?? 10)->orderBy("id", "DESC")->get());
        }
        return CardCollectionResource::collection($sharedCollections->orderBy("id", "DESC")->get());
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
        $user = auth()->user();

        if($cardCollection->user_id == $user->id || $user->id == 1) {
            $cardCollection->dailyTests()->delete();
            $cardCollection->cardEndCoefficients()->delete();
            $cardCollection->cardResults()->delete();
            $cardCollection->sharedCollections()->delete();
            $cardCollection->cards()->delete();

            $cardCollection->delete();
            return response()->json([
                'data' => [
                    'message' => 'Ieraksts veiksmīgi dzēsts!',
                ],
            ], 204);
        }
        return response()->json([
            'data' => [
                'message' => 'Jums nepieder šī kolekcija',
            ],
        ], 403);
    }

    public function checkIfNotOwner(int $card_collection_id) {
        $user = auth()->user();
        $card_collection = CardCollection::where("id", $card_collection_id)->first();
        if ($card_collection->user_id == $user->id) {
            return response()->json([
                'data' => [
                    'message' => 'Kolekcijas autors nevar saņemt savu kolekciju!',
                ],
            ], 422);
        }
        return response()->json([
            'data' => [
                'message' => 'Kolekciju drīkst saņemt!',
            ],
        ], 200);
    }

    public function generateCollectionShareLink(int $card_collection_id){
        return URL::temporarySignedRoute('CollectionShareLink', now()->addHours(3), ['id' => $card_collection_id]);
    }

    public function receiveSharedCollection(int $card_collection_id){
        $user = auth()->user();
        $card_collection = CardCollection::where("id", $card_collection_id)->first();
        SharedCollection::create([
            'user_id' => $user->id,
            'card_collection_id' => $card_collection_id,
            ]);
        return response()->json([
            'data' => [
                'message' => 'Kolekcija saņemta!',
                'title' => $card_collection->title,
            ],
        ], 200);
        // 422 for own collection
    }
}
