<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->text(70);
        $slug = Str::slug($title);
        return [
            'title' => $title,
            'user_id' => fake()->randomElement(User::all()->modelKeys()),
            'slug' => $slug,
            'content' => fake()->paragraph(50),
            'published_at' => fake()->dateTime(timezone: 'Asia/Kolkata')
        ];
    }
}
