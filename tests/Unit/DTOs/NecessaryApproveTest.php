<?php

namespace Tests\Unit\DTOs;

use App\DTOs\NecessaryApprove;
use App\Enums\ApproveCategoryEnum;
use Illuminate\Support\Arr;
use Tests\TestCase;

class NecessaryApproveTest extends TestCase
{
    /**
     * @test
     */
    public function on_get_andromeda_rules_with_correctly_approves_should_return_approved_condition(): void
    {
        $team = config('teams.andromeda');
        $backendRequiredApproves = collect(Arr::get($team, 'devs.tech_lead'))
            ->union(Arr::get($team, 'consultant-be'));
        $backendMembers = Arr::get($team, 'devs.backend');

        $backendApprove = new NecessaryApprove();
        $backendApprove->setCategory(ApproveCategoryEnum::BACKEND);
        $backendApprove->setMinApproves(2);
        $backendApprove->setRequiredApproves($backendRequiredApproves->toArray());
        $backendApprove->setAtLeastApproves($backendMembers);
        
        $backendApprove->setAuthors([
            Arr::get($team, 'devs.tech_lead')[0],
            Arr::get($team, 'devs.backend')[0],
            Arr::get($team, 'devs.backend')[1],
        ]);
        
        $this->assertTrue($backendApprove->isApproved());
    }

    /**
     * @test
     */
    public function on_get_andromeda_rules_with_non_required_approves_should_return_false(): void
    {
        $team = config('teams.andromeda');
        $backendRequiredApproves = collect(Arr::get($team, 'devs.tech_lead'))
            ->union(Arr::get($team, 'consultant-be'));
        $backendMembers = Arr::get($team, 'devs.backend');

        $backendApprove = new NecessaryApprove();
        $backendApprove->setCategory(ApproveCategoryEnum::BACKEND);
        $backendApprove->setMinApproves(2);
        $backendApprove->setRequiredApproves($backendRequiredApproves->toArray());
        $backendApprove->setAtLeastApproves($backendMembers);

        $backendApprove->setAuthors([
            Arr::get($team, 'devs.backend')[0],
            Arr::get($team, 'devs.backend')[1],
        ]);

        $this->assertFalse($backendApprove->isApproved());
    }

    /**
     * @test
     */
    public function on_test_approve_without_at_least_approves_should_return_true(): void
    {
        $infrastructureRequiredApproves = config('teams.infrastructure');

        $backendApprove = new NecessaryApprove();
        $backendApprove->setCategory(ApproveCategoryEnum::INFRASTRUCTURE);
        $backendApprove->setRequiredApproves($infrastructureRequiredApproves);

        $backendApprove->setAuthors(config('teams.infrastructure'));

        $this->assertTrue($backendApprove->isApproved());
    }

}
