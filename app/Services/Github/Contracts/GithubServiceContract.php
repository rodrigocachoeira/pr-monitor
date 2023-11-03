<?php

namespace App\Services\Github\Contracts;

use App\Enums\RepositoryEnum;
use Illuminate\Support\Collection;

interface GithubServiceContract
{
    public function getPullRequests(string $user, RepositoryEnum $repositoryName): Collection;
    
    public function getPullRequestMoreData(RepositoryEnum $repository, array $pullRequest): array;
}