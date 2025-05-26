<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardResult extends Model
{
    protected $fillable = [
        'user_id',
        'card_collection_id',
        'card_id',
        'coefficient',
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function card(): belongsTo
    {
        return $this->belongsTo(Card::class);
    }

    public function collection(): belongsTo
    {
        return $this->belongsTo(CardCollection::class);
    }
}
