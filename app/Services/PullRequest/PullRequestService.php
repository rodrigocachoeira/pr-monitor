<?php

namespace App\Services\PullRequest;

use App\Enums\RepositoryEnum;
use App\Services\ApproveRules\Contracts\ApproveRulesServiceContract;
use App\Services\ApproveRules\Teams\AndromedaRules;
use App\Services\Github\Contracts\GithubServiceContract;
use App\Services\PullRequest\Contracts\PullRequestServiceContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PullRequestService implements PullRequestServiceContract
{
    public function __construct(
        private GithubServiceContract $githubService,
        private ApproveRulesServiceContract $approveRulesService
    ){}
    
    public function getMyPullRequests(array $repositories): Collection
    {
        $key = config('cache.keys.my_personal_pull_requests');
        $expirationTime = config('cache.expiration_time.six_months');
        
        $pullRequests = Cache::remember($key, $expirationTime, function () {
            return $this->githubService->getPullRequest(RepositoryEnum::SERVICE_FACIAL_AUTH_API);    
        });
        
        $pullRequests->transform(function ($pullRequest) {
            $reviewers = collect($pullRequest['approves'])->pluck('author');
            $requestedReviewers = collect($pullRequest['requestedReviewers'])->pluck('slug');
            $changedFiles = $pullRequest['files'];

            $pullRequest['requiredReviewers'] = $this->approveRulesService->getApproveValidation(
                new AndromedaRules(), $requestedReviewers->toArray(), $reviewers->toArray(), $changedFiles->toarray()
            );
            
            return $pullRequest;
        });
        
        return $pullRequests;
    }
}