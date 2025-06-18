<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DailyTestResource;
use App\Models\CardCollection;
use App\Models\CardEndCoefficient;
use App\Models\DailyTest;
use App\Models\SharedCollection;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DailyTestController extends Controller
{
    public function generateDailyTest()
    {
        DB::table('daily_tests')->delete();
        foreach (User::all() as $user) {
            foreach ($user->cardCollections as $cardCollection) {
                $card_ids = [];
                foreach ($cardCollection->cards as $card) {
                    $cardEndResult = CardEndCoefficient::where('card_id', $card->id)->where('user_id', $user->id)->first();

                    switch ($cardEndResult->updated_at->toDateString()) {
                        case Carbon::now()->toDateString(): // all smaller than 1
                            if ($cardEndResult->coefficient < 1) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDay()->toDateString(): // all smaller than 2
                            if ($cardEndResult->coefficient < 2) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(2)->toDateString(): // all smaller than 3
                            if ($cardEndResult->coefficient < 3) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(3)->toDateString(): // all smaller than 4
                            if ($cardEndResult->coefficient < 4) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(4)->toDateString(): // all smaller than 5
                            if ($cardEndResult->coefficient < 5) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(5)->toDateString(): // all smaller than 6
                            if ($cardEndResult->coefficient < 6) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(6)->toDateString(): // all smaller than 7
                            if ($cardEndResult->coefficient < 7) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(7)->toDateString(): // all smaller than 8
                            if ($cardEndResult->coefficient < 8) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(8)->toDateString(): // all smaller than 9
                            if ($cardEndResult->coefficient < 9) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(9)->toDateString(): // all smaller than 10
                            if ($cardEndResult->coefficient < 10) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(10)->toDateString(): // all smaller than 10
                                $card_ids[] = $cardEndResult->card_id;
                            break;
                        default:
                            break;
                    }
                }
                DailyTest::create([
                    'user_id' => $user->id,
                    'card_collection_id' => $cardCollection->id,
                    'card_ids' => $card_ids,
                ]);
            }
            $sharedCollectionIds = SharedCollection::where('user_id', $user->id)
                ->pluck('card_collection_id') // Ensure correct column reference
                ->toArray(); // Convert collection to array for safer querying

            $sharedCollections = CardCollection::whereIn('id', $sharedCollectionIds)->orderBy('id', 'DESC')->get();
            foreach ($sharedCollections as $cardCollection) {
                $card_ids = [];
                foreach ($cardCollection->cards as $card) {
                    $cardEndResult = CardEndCoefficient::where('card_id', $card->id)->where('user_id', $user->id)->first();

                    switch ($cardEndResult->updated_at->toDateString()) {
                        case Carbon::now()->toDateString(): // all smaller than 1
                            if ($cardEndResult->coefficient < 1) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDay()->toDateString(): // all smaller than 2
                            if ($cardEndResult->coefficient < 2) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(2)->toDateString(): // all smaller than 3
                            if ($cardEndResult->coefficient < 3) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(3)->toDateString(): // all smaller than 4
                            if ($cardEndResult->coefficient < 4) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(4)->toDateString(): // all smaller than 5
                            if ($cardEndResult->coefficient < 5) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(5)->toDateString(): // all smaller than 6
                            if ($cardEndResult->coefficient < 6) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(6)->toDateString(): // all smaller than 7
                            if ($cardEndResult->coefficient < 7) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(7)->toDateString(): // all smaller than 8
                            if ($cardEndResult->coefficient < 8) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(8)->toDateString(): // all smaller than 9
                            if ($cardEndResult->coefficient < 9) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(9)->toDateString(): // all smaller than 10
                            if ($cardEndResult->coefficient < 10) {
                                $card_ids[] = $cardEndResult->card_id;
                            }
                            break;
                        case Carbon::now()->subDays(10)->toDateString(): // all smaller than 10
                            $card_ids[] = $cardEndResult->card_id;
                            break;
                        default:
                            break;
                    }
                }
                DailyTest::create([
                    'user_id' => $user->id,
                    'card_collection_id' => $cardCollection->id,
                    'card_ids' => $card_ids,
                ]);
            }
        }
        return response()->json([
            'data' => [
                'message' => 'Tabula Atjaunota veiksmīgi!',
            ],
        ], 200);
    }

    public function show(int $card_collection_id) {
        $user = auth()->user();
        $dailyTest = DailyTest::where('card_collection_id', $card_collection_id)->where('user_id', $user->id)->first();
        if ($dailyTest) {
            return new DailyTestResource($dailyTest);
        }
        return response()->json([], 204);
    }

    public function testInfo(int $card_collection_id) {
        $user = auth()->user();
        $dailyTest = DailyTest::where('card_collection_id', $card_collection_id)->where('user_id', $user->id)->first();
        if ($dailyTest) {
            return new DailyTestResource($dailyTest);
        }
        return response()->json([], 204);

    }
}
