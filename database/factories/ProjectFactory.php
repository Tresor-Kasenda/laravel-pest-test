<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'images' => fake()->image,
            'content' => fake()->realText,
            'user_id' => User::factory()
        ];
    }
}
