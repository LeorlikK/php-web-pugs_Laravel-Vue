<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'user' => $this->user->login,
            'image_url' => $this->image_url,
            'title' => $this->title,
            'short' => $this->short,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at,
        ];
    }
}
