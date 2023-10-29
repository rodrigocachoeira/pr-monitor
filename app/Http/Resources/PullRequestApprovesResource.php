<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class PullRequestApprovesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return collect(Arr::get($this, 'approves'))->map(function ($consultant) {
            return [
                'author' => Arr::get($consultant, 'author'),
                'avatarUrl' => Arr::get($consultant, 'avatarUrl'),
                'reviewedAt' => Arr::get($consultant, 'reviewedAt'),
            ];
        })->values()->toArray();
    }
}
