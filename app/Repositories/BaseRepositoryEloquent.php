<?php

namespace App\Repositories;

use App\Models\PullRequest;
use App\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepositoryEloquent implements BaseRepositoryContract
{
    protected Model $model;
    
    public function all(): Collection
    {
        return $this->model->all();
    }
}