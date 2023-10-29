<?php

namespace App\Repositories;

use App\Models\PullRequest;
use App\Repositories\Contracts\PullRequestRepositoryContract;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PullRequestRepositoryEloquent extends BaseRepositoryEloquent implements PullRequestRepositoryContract
{
    public function __construct(PullRequest $pullRequest)
    {
        $this->model = $pullRequest;
    }
    
    public function syncPullRequests(string $repository, Collection $pullRequests): bool
    {
        $numbers = $pullRequests->pluck('id');
        
        try {
            $alreadyExist = $this->model->whereIn('id', $numbers)->get('id');

            $pullRequests->filter(function ($pullRequest) use ($alreadyExist) {
                return ! $alreadyExist->contains($pullRequest['id']);
            })->each(function ($pullRequest) use ($repository) {
                $this->insertPullRequest($pullRequest, $repository);
            });
            
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            
            return false;
        }
    }
    
    function insertPullRequest($pullRequest, string $repository): void
    {
        $this->model->create([
            'github_id' => $pullRequest['id'],
            'number' => $pullRequest['number'],
            'repository' => $repository,
            'title' => $pullRequest['title'],
            'body' => $pullRequest['body'],
            'published_at' => $pullRequest['created_at'],
        ]);
    }
}