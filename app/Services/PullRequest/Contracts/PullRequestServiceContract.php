<?php

namespace App\Services\PullRequest\Contracts;

use Illuminate\Support\Collection;

interface PullRequestServiceContract
{
    public function getMyPullRequests(array $repositories): Collection;
}