<?php

namespace Tests\Feature\Repositories;

use App\Enums\RepositoryEnum;
use App\Repositories\Contracts\PullRequestRepositoryContract;
use Tests\ExternalServices\GithubApiMock;
use Tests\TestCase;

class PullRequestRepositoryEloquentTest extends TestCase
{
    use GithubApiMock;
    
    private PullRequestRepositoryContract $pullRequestRepository;
    
    public function setUp(): void
    {
        parent::setUp();
        
        $this->pullRequestRepository = app(PullRequestRepositoryContract::class);
    }

    /**
     * @test
     */
    public function on_send_multiple_pull_requests_to_empty_database_should_persist_all_records(): void
    {
        $this->createGithubRepositoryMock();
        $repository = RepositoryEnum::SERVICE_FACIAL_AUTH_API->value;
        
        $pullRequestsGithub = $this->gitHubApi->getPullRequests($repository);
        $sync = $this->pullRequestRepository->syncPullRequests($repository, $pullRequestsGithub);
        
        $this->assertTrue($sync);
        $this->assertCount($pullRequestsGithub->count(), $this->pullRequestRepository->all());
    }
    
}
