<?php

namespace App\Services\ApproveRules\Teams;

use App\DTOs\NecessaryApprove;
use App\Enums\ApproveCategoryEnum;
use Illuminate\Support\Arr;

abstract class TeamRulesAbstract
{
    protected array $config;
    
    protected array $authors;
    
    public function setReviewers(array $authors): void
    {
        $this->authors = $authors;
    }

    public function getFrontendRules(): NecessaryApprove
    {
        $requiredApproves = Arr::get($this->config, 'consultant-fe');

        $approve = new NecessaryApprove();
        $approve->setCategory(ApproveCategoryEnum::FRONTEND);
        $approve->setMinApproves(2);
        $approve->setRequiredApproves($requiredApproves);
        $approve->setAuthors($this->authors);

        return $approve;
    }
    public function getBackendRules(): NecessaryApprove
    {
        $requiredApproves = collect(Arr::get($this->config, 'devs.tech_lead'))
            ->union(Arr::get($this->config, 'consultant-be'));

        $approve = new NecessaryApprove();
        $approve->setCategory(ApproveCategoryEnum::BACKEND);
        $approve->setMinApproves(2);
        $approve->setRequiredApproves($requiredApproves->toArray());
        $approve->setAuthors($this->authors);

        return $approve;
    }

    public function getInfrastructureRules(): NecessaryApprove
    {
        $requiredApproves = collect(Arr::get($this->config, 'infrastructure'));

        $approve = new NecessaryApprove();
        $approve->setCategory(ApproveCategoryEnum::INFRASTRUCTURE);
        $approve->setRequiredApproves($requiredApproves->toArray());
        $approve->setAuthors($this->authors);

        return $approve;
    }
}