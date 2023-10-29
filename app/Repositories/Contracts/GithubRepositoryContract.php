<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface GithubRepositoryContract
{
    public function getPullRequests(string $repositoryName): Collection;   
    
    public function getConsultantsOfTeams(array $requestedTeams): Collection;
    
    public function getPullRequestApproves(string $repositoryName, string $pullRequestNumber): Collection;
    
    public function getChangedFilesPullRequest(string $repositoryName, string $pullRequestNumber): Collection;
}