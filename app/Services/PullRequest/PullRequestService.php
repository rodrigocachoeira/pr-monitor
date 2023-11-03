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
    
    public function getMyPullRequests(string $user, array $repositories): Collection
    {
        $key = config('cache.keys.my_personal_pull_requests');
        $expirationTime = config('cache.expiration_time.six_months');
        
        $repositoryPullRequests = Cache::remember($key, $expirationTime, function () use ($user, $repositories) {
            return $this->getPullRequestsOfUser($user, $repositories);
        });
        
        return $this->applyApproveRules($repositoryPullRequests);
    }
    
    private function applyApproveRules(Collection $repositoryPullRequests): Collection
    {
        return $repositoryPullRequests->map(function ($repositoryPullRequest) {
            $repository = $repositoryPullRequest['repository'];
            $pullRequests = $repositoryPullRequest['pullRequests'];

            $pullRequests->transform(function ($pullRequest) {
                $reviewers = collect($pullRequest['approves'])->pluck('author');
                $requestedReviewers = collect($pullRequest['requestedReviewers'])->pluck('slug');
                $changedFiles = $pullRequest['files'];

                $pullRequest['requiredReviewers'] = $this->approveRulesService->getApproveValidation(
                    new AndromedaRules(), $requestedReviewers->toArray(), $reviewers->toArray(), $changedFiles->toarray()
                );

                return $pullRequest;
            });
            
            return [
                'repository' => $repository,
                'pullRequests' => $pullRequests,
            ];
        });
    }
    
    private function getPullRequestsOfUser(string $user, array $repositories): Collection
    {
        return collect($repositories)->map(function (RepositoryEnum $repository) use ($user) {
            $pullRequests = $this->githubService->getPullRequests($user, $repository);
            
            return [
                'repository' => $repository,
                'pullRequests' => $pullRequests,
            ];
        });
    }
}