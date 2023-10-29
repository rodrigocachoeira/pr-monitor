<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface PullRequestRepositoryContract extends BaseRepositoryContract
{
    public function syncPullRequests(string $repository, Collection $pullRequests): bool;
}