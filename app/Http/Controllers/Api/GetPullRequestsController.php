<?php

namespace App\Http\Controllers\Api;

use App\Builders\Responses\ResponseBuilder;
use App\Services\PullRequest\Contracts\PullRequestServiceContract;
use Illuminate\Http\JsonResponse;

class GetPullRequestsController
{
    public function __construct(
        private PullRequestServiceContract $pullRequestService
    ){}

    public function __invoke(): JsonResponse
    {
        $pullRequests = $this->pullRequestService->getMyPullRequests([]);
        
        return ResponseBuilder::init()
            ->data([
                'pullRequests' => $pullRequests,
            ])
            ->build();
    }
}
