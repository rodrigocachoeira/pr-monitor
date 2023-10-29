<?php

namespace App\Providers\Github;

use App\Services\Github\Contracts\GithubServiceContract;
use App\Services\Github\GithubService;
use Carbon\Laravel\ServiceProvider;
use GuzzleHttp\Client;

class GithubServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            GithubServiceContract::class,
            GithubService::class
        );
    }

    public function provides(): array
    {
        return [
            GithubServiceContract::class
        ];
    }
}
