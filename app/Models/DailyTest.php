<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyTest extends Model
{
    protected $fillable = [
        'user_id',
        'card_collection_id',
        'card_ids'
    ];

    protected function casts(): array
    {
        return [
            'card_ids' => 'array',
        ];
    }
}
