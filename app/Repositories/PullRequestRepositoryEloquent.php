<?php

namespace App\Repositories;

use App\Models\PullRequest;
use App\Repositories\Contracts\PullRequestRepositoryContract;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PullRequestRepositoryEloquent implements PullRequestRepositoryContract
{
    protected PullRequest $model;
    
    public function __construct(PullRequest $pullRequest)
    {
        $this->model = $pullRequest;
    }
    
    public function syncPullRequests(Collection $pullRequests): bool
    {
        try {
            $numbers = $pullRequests->pluck('number');
            $this->model->whereIn('number', $numbers)->get();
            
        } catch (Exception $e) {
            Log::error($e->getMessage());
            
            return false;
        }
        
        return true;
    }
}