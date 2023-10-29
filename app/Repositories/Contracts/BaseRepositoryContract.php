<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface BaseRepositoryContract
{
    public function all(): Collection;
}