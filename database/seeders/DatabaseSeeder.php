<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\CardCollection;
use App\Models\CardResult;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);
        User::create([
            'username' => 'test',
            'email' => 't@t.t',
            'password' => Hash::make('ttt'),
        ]);
        CardCollection::create([
            'title' => "にほんご",
            'user_id' => "1"
        ]);
        Card::create([
            'card_collection_id' => 1,
            'card_front' => "くるま",
            'card_back' => "Mašīna",
        ]);
        Card::create([
            'card_collection_id' => 1,
            'card_front' => "わたしは__です",
            'card_back' => "Mani sauc __",
        ]);
        Card::create([
            'card_collection_id' => 1,
            'card_front' => "おおきい",
            'card_back' => "Liels",
        ]);

        foreach (CardCollection::all() as $cardCollection) {
            $user = $cardCollection->user;
            foreach (Card::all()->where('card_collection_id', $cardCollection->id) as $card) {

                $cardResult = CardResult::create([
                    'card_id' => $card->id,
                    'user_id' => $user->id,
                    'card_collection_id' => $cardCollection->id,
                    'coefficient' => rand(-1, 2),
                ]);
//                $user->cardResults()->attach($card, [
//                    'card_collection_id' => $cardCollection->id,
//                    'coefficient' => rand(-1, 2)
//                ]);
            }
        }
    }
}
