<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardCollectionStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'stats' => StatsResource::collection($this->stats)->sortBy('id')->values(),
            'cards' => CardResource::collection($this->cards)->sortBy('id')->values(),
        ];
    }
}
