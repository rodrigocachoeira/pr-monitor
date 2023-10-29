<?php

namespace Tests\ExternalServices;

use App\Repositories\Contracts\GithubRepositoryContract;
use App\Repositories\GithubRepositoryApi;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Mockery;

trait GithubApiMock
{
    protected GithubRepositoryContract $gitHubApi;
    
    public function setUp(): void
    {
        parent::setUp();
    }
    
    public function createGithubRepositoryMock(): void
    {
        $mock = Mockery::mock(GithubRepositoryApi::class, function (MockInterface $mock) {
            $mock->shouldReceive('getPullRequests')->once()->andReturn($this->mockGetPullRequests());
        });

        $this->instance(GithubRepositoryContract::class, $mock);
        
        $this->gitHubApi = $mock;
    }
    
    private function mockGetPullRequests(): Collection
    {
        return collect(range(1, 5))->map(function ($n) {
            return [
                'id' => fake()->unique()->numberBetween(),
                'number' => fake()->unique()->numberBetween(0, 9999),
                'state' => 'open',
                'title' => fake()->text,
                'user' => [
                    'login' => fake()->name,
                    'avatar_url' => fake()->url,
                ],
                'body' => fake()->text,
                'created_at' => fake()->dateTime,
                'requested_reviewers' => [],
                'requested_teams' => [],
            ];
        });
    }
}