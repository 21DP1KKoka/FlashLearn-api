<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardCollection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'user_id',
        'firstuse',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function cardResults(): HasMany
    {
        return $this->hasMany(CardResult::class);
    }

    public function cardEndCoefficients(): HasMany
    {
        return $this->hasMany(CardEndCoefficient::class);
    }
    public function dailyTests(): HasMany
    {
        return $this->hasMany(DailyTest::class);
    }

    public function sharedCollections(): HasMany
    {
        return $this->hasMany(SharedCollection::class);
    }
}
