<?php

namespace App\Http\Resources\Marker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            //'created_at' => $this->created_at,
            //'time_ago' => $this->created_at->diffForHumans(),
        ];
    }
}
