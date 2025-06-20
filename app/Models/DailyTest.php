<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cardCollections(): BelongsTo
    {
        return $this->belongsTo(CardCollection::class);
    }
}
