<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now = now();
        $randomDays = fake()->numberBetween(0, 10);
        $randomDate = $now->addDays($randomDays);
        return [
            'user_id' => fake()->randomElement(User::all()->modelKeys()),
            'title' => fake()->text(70),
            'description' => fake()->paragraph(),
            'due_date' => $randomDate
        ];
    }
}
