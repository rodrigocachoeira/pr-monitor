<?php

namespace Tests\Unit\Services\Github;

use App\Services\Github\Contracts\GithubServiceContract;
use App\Services\Github\GithubService;
use Tests\TestCase;

class GithubServiceTest extends TestCase
{
    /**
     * @var GithubServiceContract 
     */
    private GithubServiceContract $githubService;
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->githubService = $this->app->make(GithubServiceContract::class);
    }

    /**
     * @test
     */
    public function on_get_repositories_should_return_an_array(): void
    {
        $repositories = $this->githubService->getPullRequest('service-facial-auth-api');
        
        dd($repositories);
    }
}
