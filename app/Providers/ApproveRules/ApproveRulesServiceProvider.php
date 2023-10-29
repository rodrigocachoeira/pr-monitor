<?php

namespace App\Providers\ApproveRules;

use App\Services\ApproveRules\ApproveRulesService;
use App\Services\ApproveRules\Contracts\ApproveRulesServiceContract;
use Carbon\Laravel\ServiceProvider;

class ApproveRulesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ApproveRulesServiceContract::class,
            ApproveRulesService::class
        );
    }

    public function provides(): array
    {
        return [
            ApproveRulesServiceContract::class
        ];
    }
}
