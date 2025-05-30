<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'user' => $this->whenLoaded('user', fn () => UserResource::make($this->user)),
            'topic' => $this->whenLoaded('topic', fn () => TopicResource::make($this->topic)),
            'title' => $this->title,
            'body' => $this->body,
            'html' => str($this->html),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'routes' => [
                'show' => $this->showRoute(),
            ],
        ];
    }
}
