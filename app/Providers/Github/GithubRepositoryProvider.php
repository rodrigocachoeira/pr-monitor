<?php

namespace App\Providers\Github;

use App\Repositories\Contracts\GithubRepositoryContract;
use App\Repositories\GithubRepositoryApi;
use App\Services\Github\Contracts\GithubServiceContract;
use App\Services\Github\GithubService;
use Carbon\Laravel\ServiceProvider;
use GuzzleHttp\Client;

class GithubRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            GithubRepositoryContract::class,
            function() {
                return new GithubRepositoryApi(
                    new Client([
                        'base_uri' => 'https://api.github.com',
                        'headers' => [
                            'User-Agent' => 'PR Monitor',
                            'Authorization' => 'token ' . config('github.token'),
                        ]
                    ])
                );
            }
        );
    }

    public function provides(): array
    {
        return [
            GithubServiceContract::class
        ];
    }
}
