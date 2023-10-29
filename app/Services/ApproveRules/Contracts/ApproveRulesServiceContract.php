<?php

namespace App\Services\ApproveRules\Contracts;

use App\Services\ApproveRules\Teams\TeamRulesAbstract;

interface ApproveRulesServiceContract
{
    public function getApproveValidation(
        TeamRulesAbstract $teamRules, 
        array $requestedReviewers,
        array $reviewers,
        array $changedFiles,
    ): array;
}
