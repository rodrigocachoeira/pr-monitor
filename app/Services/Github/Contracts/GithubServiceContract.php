<?php

namespace App\Services\Github\Contracts;

use App\Enums\RepositoryEnum;
use Illuminate\Support\Collection;

interface GithubServiceContract
{
    public function getPullRequest(RepositoryEnum $repositoryName): Collection;
}