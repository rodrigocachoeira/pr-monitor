<?php

namespace App\Providers\PullRequest;

use App\Services\PullRequest\Contracts\PullRequestServiceContract;
use App\Services\PullRequest\PullRequestService;
use Carbon\Laravel\ServiceProvider;

class PullRequestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PullRequestServiceContract::class,
            PullRequestService::class
        );
    }

    public function provides(): array
    {
        return [
            PullRequestServiceContract::class
        ];
    }
}
