<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cardCollections(): HasMany
    {
        return $this->hasMany(CardCollection::class);
    }

    public function cardResults(): HasMany
    {
        return $this->hasMany(CardResult::class);
    }

    public function cardEndCoefficients(): HasMany
    {
        return $this->hasMany(CardEndCoefficient::class);
    }

    public function dailyTest(): HasOne
    {
        return $this->hasOne(DailyTest::class);
    }

    public function sharedCollections(): HasMany
    {
        return $this->hasMany(SharedCollection::class);
    }
}
