<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Card extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'card_front',
        'card_back',
        'card_collection_id',
    ];

    public function cardCollection(): BelongsTo
    {
        return $this->belongsTo(CardCollection::class);
    }

    public function cardResults(): HasMany
    {
        return $this->hasMany(CardResult::class);
    }

    public function cardEndCoefficients(): HasMany
    {
        return $this->hasMany(CardEndCoefficient::class);
    }

}
