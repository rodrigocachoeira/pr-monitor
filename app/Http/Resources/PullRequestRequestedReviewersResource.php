<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class PullRequestRequestedReviewersResource extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return collect(Arr::get($this, 'requestedReviewers'))->map(function ($consultant) {
            return [
                'name' => Arr::get($consultant, 'name'),
                'slug' => Arr::get($consultant, 'slug'),
            ];
        })->toArray();
    }
}
