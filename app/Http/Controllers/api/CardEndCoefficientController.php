<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatsResource;
use App\Models\CardEndCoefficient;
use App\Models\CardResult;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CardEndCoefficientController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function updateEndCoefficient() {
        foreach (User::all() as $user) {
            foreach ($user->cardCollections as $cardCollection) {
                foreach ($cardCollection->cards as $card) {
                    $date = Carbon::now()->subHour()->toDateString();
                    $cardResult = CardResult::latest()->where('card_id', $card->id)->whereDate('created_at', $date)->first();
                    if ($cardResult) {
                        $cardEndCoefficient = CardEndCoefficient::where('card_id', $card->id)->where('user_id', $user->id)->first();
                        if (!$cardEndCoefficient) {
                            if ($cardResult->coefficient < 0) {
                                $cardResult->coefficient = 0;
                            }
                            $cardEndCoefficient = CardEndCoefficient::create([
                                'card_id' => $card->id,
                                'user_id' => $user->id,
                                'card_collection_id' => $cardCollection->id,
                                'coefficient' => $cardResult->coefficient,
                            ]);
                        }
                        else {

                            if (($cardEndCoefficient->coefficient + $cardResult->coefficient) < 0) {
                                continue;
                            }
                            $newCoefficient = min($cardEndCoefficient->coefficient + $cardResult->coefficient, 10);
                            $cardEndCoefficient->update([
                                'coefficient' => $newCoefficient
                            ]);
                        }
                    }
                    else {
                        $cardEndCoefficient = CardEndCoefficient::create([
                            'card_id' => $card->id,
                            'user_id' => $user->id,
                            'card_collection_id' => $cardCollection->id,
                            'coefficient' => 0,
                        ]);
                    }
                }
            }
        }
        return response()->json([
            'data' => [
                'message' => 'Tabula atjaunota veiksmīgi!',
            ],
        ], 200);
    }

    /**
     * @param int $card_collection_id
     * @return ResourceCollection
     */
    public function returnStatistics(int $card_collection_id):ResourceCollection {
        $user = auth()->user();
        return StatsResource::collection(CardEndCoefficient::all()->where('card_collection_id', $card_collection_id)->where('user_id', $user->id));
    }
}
