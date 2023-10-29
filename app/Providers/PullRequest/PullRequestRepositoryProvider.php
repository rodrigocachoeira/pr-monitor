<?php

namespace App\Providers\PullRequest;

use App\Repositories\Contracts\PullRequestRepositoryContract;
use App\Repositories\PullRequestRepositoryEloquent;
use App\Services\PullRequest\Contracts\PullRequestServiceContract;
use App\Services\PullRequest\PullRequestService;
use Carbon\Laravel\ServiceProvider;

class PullRequestRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PullRequestRepositoryContract::class,
            PullRequestRepositoryEloquent::class
        );
    }

    public function provides(): array
    {
        return [
            PullRequestRepositoryContract::class
        ];
    }
}
