<?php

namespace App\Services\Github;

use App\Enums\RepositoryEnum;
use App\Repositories\Contracts\GithubRepositoryContract;
use App\Services\Github\Contracts\GithubServiceContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class GithubService implements GithubServiceContract
{
    public function __construct(private readonly GithubRepositoryContract $githubRepository)
    {}
    
    public function getPullRequests(string $user, RepositoryEnum $repositoryName): Collection
    {
        $pullRequests = $this->githubRepository->getPullRequests($repositoryName->value);
        
        return $pullRequests
            ->filter(function ($pullRequest) use ($user) { 
                return Arr::get($pullRequest, 'user.login') == $user;
            })->map(function ($pullRequest) use ($repositoryName) {
                return $this->getPullRequestMoreData($repositoryName, $pullRequest);
            })
            ->values();
    }

    public function getPullRequestMoreData(RepositoryEnum $repository, array $pullRequest): array
    {
        return [
            'data' => $pullRequest,
            'requestedReviewers' => $this->githubRepository->getConsultantsOfTeams($pullRequest['requested_teams']),
            'approves' => $this->githubRepository->getPullRequestApproves($repository->value, $pullRequest['number']),
            'files' => $this->githubRepository->getChangedFilesPullRequest($repository->value, $pullRequest['number']),
        ];
    }
}
