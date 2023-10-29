<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class PullRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'task' => $this->getTaskName(Arr::get($this, 'head.label')),
            'number' => Arr::get($this, 'number'),
            'title' => Arr::get($this, 'title'),
            'body' => Arr::get($this, 'body'),
            'repository' => Arr::get($this, 'repository'),
            'files' => Arr::get($this, 'files'),
            'publishedAt' => (new Carbon(Arr::get($this, 'created_at')))->diffForHumans(),
            'requestedReviewers' => (new PullRequestRequestedReviewersResource($this))->toArray(new Request()),
            'approves' => (new PullRequestApprovesResource($this))->toArray(new Request()),
            'author' => (new PullRequestAuthorResource($this))->toArray(new Request()),
        ];
    }

    private function getTaskName(?string $branch): ?string
    {
        if (preg_match('/[A-Za-z]+-\d+/', $branch, $matches)) {
            return $matches[0];
        }

        return null;
    }
}

