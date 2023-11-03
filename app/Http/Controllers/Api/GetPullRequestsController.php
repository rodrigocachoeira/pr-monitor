<?php

namespace App\Http\Controllers\Api;

use App\Builders\Responses\ResponseBuilder;
use App\Enums\RepositoryEnum;
use App\Http\Resources\PullRequestResource;
use App\Services\PullRequest\Contracts\PullRequestServiceContract;
use Illuminate\Http\JsonResponse;

class GetPullRequestsController
{
    public function __construct(
        private readonly PullRequestServiceContract $pullRequestService
    ){}

    public function __invoke(): JsonResponse
    {
        $pullRequests = $this->pullRequestService->getMyPullRequests(
            'tfarias',
            [
                RepositoryEnum::SERVICE_FACIAL_AUTH_API,
                RepositoryEnum::FM_SITE_BR,
            ]
        );
        
        return ResponseBuilder::init()
            ->data([
                'pullRequests' => PullRequestResource::collection($pullRequests),
            ])
            ->build();
    }
}
