<?php

namespace App\Http\Controllers;

use App\Models\CardCollection;
use App\Models\CardEndCoefficient;
use App\Models\CardResult;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CardEndCoefficientController extends Controller
{
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
                            $newCoefficient = $cardEndCoefficient->coefficient + $cardResult->coefficient;
                            $cardEndCoefficient->update([
                                'coefficient' => $newCoefficient
                            ]);
                        }
                    }
                }
            }
        }
        return response()->json([
            'data' => [
                'message' => 'Tabula Atjaunota veiksmīgi!',
            ],
        ], 200);
    }
}
