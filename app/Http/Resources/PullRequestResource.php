<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        $pullRequests = Arr::get($this, 'pullRequests', []);
        $repository = Arr::get($this, 'repository');
        
        return collect($pullRequests)->map(function ($pullRequest) use ($repository) {
            return [
                'task' => $this->getTaskName(Arr::get($pullRequest, 'data.head.label')),
                'number' => Arr::get($pullRequest, 'data.number'),
                'title' => Arr::get($pullRequest, 'data.title'),
                'body' => Arr::get($pullRequest, 'data.body'),
                'repository' => $repository,
                'files' => Arr::get($pullRequest, 'files'),
                'publishedAt' => (new Carbon(Arr::get($pullRequest, 'data.created_at')))->diffForHumans(),
                'requestedReviewers' => (new PullRequestRequestedReviewersResource($pullRequest))->toArray(new Request()),
                'approves' => (new PullRequestApprovesResource($pullRequest))->toArray(new Request()),
                'author' => (new PullRequestAuthorResource($pullRequest))->toArray(new Request()),
            ];
        })->toArray();
    }

    private function getTaskName(string $branch): ?string
    {
        if (preg_match('/[A-Za-z]+-\d+/', $branch, $matches)) {
            return $matches[0];
        }

        return null;
    }
}

