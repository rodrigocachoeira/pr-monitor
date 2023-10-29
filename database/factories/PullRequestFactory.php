<?php

namespace Database\Factories;

use App\Enums\RepositoryEnum;
use App\Models\PullRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PullRequest>
 */
class PullRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'github_id' => fake()->unique()->randomNumber(8),
            'number' => fake()->randomNumber(4),
            'repository' => collect(RepositoryEnum::cases())->random()->value,
            'title' => fake()->word,
            'body' => fake()->text,
            'published_at' => fake()->dateTime,
        ];
    }
}
