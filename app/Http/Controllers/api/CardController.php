<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;
use App\Http\Resources\CardResource;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CardController extends Controller
{
    /**
     * @return ResourceCollection
     */
    public function index(): ResourceCollection {
        if (request()->page) {
            return CardResource::collection(Card::paginate((request()->pagination) ?? 10));
        }
        return CardResource::collection(Card::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @param CardRequest $request
     * @return CardResource
     */
    public function store(CardRequest $request): CardResource {
        $validated = $request->validated();
        $card = Card::create($validated);
        return new CardResource($card);
    }

    /**
     * @param Card $card
     * @return CardResource
     */
    public function show(Card $card): CardResource {
        return new CardResource($card);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * @param CardRequest $request
     * @param Card $card
     * @return CardResource
     */
    public function update(CardRequest $request, Card $card): CardResource {
        $validated = $request->validated();
        $card->update($validated);
        return new CardResource($card);
    }

    /**
     * @param Card $card
     * @return JsonResponse
     */
    public function destroy(Card $card): JsonResponse {
        $user = auth()->user();
        if ($card->cardCollection->user_id == $user->id || $user->id == 1) {

            $card->delete();
            return response()->json([
                'data' => [
                    'message' => 'Ieraksts veiksmīgi dzēsts!',
                ],
            ], 204);
        }
        return response()->json([
            'data' => [
                'message' => 'Jums nepieder šī kartīte!',
            ],
        ], 403);
    }
}
