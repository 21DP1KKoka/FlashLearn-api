<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardEndCoefficient extends Model
{
    protected $fillable = [
        'user_id',
        'card_id',
        'card_collection_id',
        'coefficient',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    public function cardCollection(): BelongsTo
    {
        return $this->belongsTo(CardCollection::class);
    }
}
