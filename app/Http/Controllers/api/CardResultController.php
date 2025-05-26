<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardResultRequest;
use App\Http\Resources\CardResultResource;
use App\Models\CardResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CardResultController extends Controller
{
    /**
     * @return ResourceCollection
     */
    public function index(): ResourceCollection {
        if (request()->page) {
            return CardResultResource::collection(CardResult::paginate((request()->pagination) ?? 10));
        }
        return CardResultResource::collection(CardResult::all());
    }


    /**
     * @param CardResultRequest $request
     * @return void
     */
    public function store(CardResultRequest $request) {
        $validated = $request->validated();
        $user = auth()->user();
        foreach ($validated['card_results'] as $cardResult) {
            CardResult::create([
                'card_id' => $cardResult['card_id'],
                'user_id' => $user->id,
                'card_collection_id' => $validated['card_collection_id'],
                'coefficient' => $cardResult['coefficient'],
            ]);
        }
        response()->json(204);
    }

    /**
     * @param CardResult $cardResult
     * @return CardResultResource
     */
    public function show(CardResult $cardResult): CardResultResource {
        return new CardResultResource($cardResult);
    }

    /**
     * @param CardResultRequest $request
     * @param CardResult $cardResult
     * @return CardResultResource
     */
    public function update(CardResultRequest $request, CardResult $cardResult): CardResultResource {
        $validated = $request->validated();
        $cardResult->update($validated);
        return new CardResultResource($cardResult);
    }

    /**
     * @param CardResult $cardResult
     * @return JsonResponse
     */
    public function destroy(CardResult $cardResult): JsonResponse {
        $cardResult->delete();
        return response()->json([
            'data' => [
                'message' => 'Ieraksts veiksmīgi dzēsts!',
            ],
        ], 204);
    }
}
