<?php

namespace App\Services\ApproveRules\Teams;

use App\DTOs\NecessaryApprove;
use App\Enums\ApproveCategoryEnum;
use Illuminate\Support\Arr;

class AndromedaRules extends TeamRulesAbstract
{
    public function __construct()
    {
        $this->config = config('teams.andromeda');
    }
}