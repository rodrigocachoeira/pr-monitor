<?php

namespace App\DTOs;

use App\Enums\ApproveCategoryEnum;

class NecessaryApprove
{
    private ApproveCategoryEnum $category;

    private array $authors;
    
    private int $minApproves;
    
    private array $requiredApproves;
    
    private array $atLeastApproves;
    
    public function __construct()
    {
        $this->atLeastApproves = [];
        $this->minApproves = 0;
    }

    public function getCategory(): ApproveCategoryEnum
    {
        return $this->category;
    }

    public function setCategory(ApproveCategoryEnum $category): void
    {
        $this->category = $category;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }

    public function setAuthors(array $authors): void
    {
        $this->authors = $authors;
    }

    public function isApproved(): bool
    {
        $hasNecessaryApproves = collect($this->requiredApproves)->filter(function (string $requiredApprove) {
            return collect($this->authors)->contains($requiredApprove);
        })->count() == count($this->requiredApproves);
        
        $hasMinimalApproves = collect($this->atLeastApproves)->filter(function (string $atLeastApprove) {
            return collect($this->authors)->contains($atLeastApprove);
        })->count() >= $this->minApproves;
        
        return $hasNecessaryApproves && $hasMinimalApproves;
    }

    public function getMinApproves(): int
    {
        return $this->minApproves;
    }

    public function setMinApproves(int $minApproves): void
    {
        $this->minApproves = $minApproves;
    }

    public function getRequiredApproves(): array
    {
        return $this->requiredApproves;
    }

    public function setRequiredApproves(array $requiredApproves): void
    {
        $this->requiredApproves = $requiredApproves;
    }

    public function setAtLeastApproves(array $atLeastApproves): void
    {
        $this->atLeastApproves = $atLeastApproves;
    }
}