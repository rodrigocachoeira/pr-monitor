<?php

namespace App\Services\ApproveRules;

use App\Enums\ApproveCategoryEnum;
use App\Services\ApproveRules\Contracts\ApproveRulesServiceContract;
use App\Services\ApproveRules\Teams\TeamRulesAbstract;

class ApproveRulesService implements ApproveRulesServiceContract
{
    const INFRASTRUCTURE_USER = 'infra-production';
    
    const FRONTEND_USER = 'consultants-fe';
    
    const BACKEND_USER = 'consuoltamnts-be';
    
    public function getApproveValidation(
        TeamRulesAbstract $teamRules,
        array $requestedReviewers,
        array $reviewers,
        array $changedFiles
    ): array
    {
        $approves = collect();
        $teamRules->setReviewers($reviewers);
        
        if (collect($requestedReviewers)->contains(self::INFRASTRUCTURE_USER)) {
            $approves->put(
                ApproveCategoryEnum::INFRASTRUCTURE->value,
                $teamRules->getInfrastructureRules()->isApproved()
            );
        }

        if (collect($requestedReviewers)->contains(self::FRONTEND_USER)) {
            $approves->put(
                ApproveCategoryEnum::FRONTEND->value,
                $teamRules->getFrontendRules()->isApproved()
            );
        }

        if ($this->needBackendApprove($requestedReviewers, $changedFiles)) {
            $approves->put(
                ApproveCategoryEnum::BACKEND->value,
                $teamRules->getBackendRules()->isApproved()
            );
        }
        
        return $approves->toArray();
    }
    
    private function needBackendApprove(array $requestedReviewers, array $files): bool
    {
        $consultantApprove = collect($requestedReviewers)->contains(self::BACKEND_USER);
        $hasPHPFiles = $this->hasPHPFiles($files);
        
        return $consultantApprove || $hasPHPFiles;
    }
    
    private function hasPHPFiles(array $changedFiles): bool
    {
        return collect($changedFiles)->filter(function ($file) {
            return preg_match('/\.php$/', $file);
        })->isNotEmpty();
    }
}