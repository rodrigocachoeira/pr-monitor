<?php

namespace App\Services\Github;

use App\Enums\RepositoryEnum;
use App\Repositories\Contracts\GithubRepositoryContract;
use App\Services\Github\Contracts\GithubServiceContract;
use Illuminate\Support\Collection;

class GithubService implements GithubServiceContract
{
    public function __construct(private readonly GithubRepositoryContract $githubRepository)
    {}
    
    public function getPullRequest(RepositoryEnum $repositoryName): Collection
    {
        $pullRequests = $this->githubRepository->getPullRequests($repositoryName->value);
        
        $pullRequests->transform(function ($pullRequest) use ($repositoryName) {
            $pullRequest['requestedReviewers'] = $this->githubRepository->getConsultantsOfTeams($pullRequest['requested_teams']);
            $pullRequest['approves'] = $this->githubRepository->getPullRequestApproves($repositoryName->value, $pullRequest['number']);
            $pullRequest['files'] = $this->githubRepository->getChangedFilesPullRequest($repositoryName->value, $pullRequest['number']);
            $pullRequest['repository'] = $repositoryName->value;
            
            return $pullRequest;
        });
        
        return $pullRequests;
    }
}
