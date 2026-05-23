<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(4, 10));
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'content' => $this->faker->paragraphs(rand(5, 15), true),
            'excerpt' => $this->faker->sentence(rand(10, 20)),
            'cover_image' => null,
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'views' => $this->faker->numberBetween(0, 15000),
        ];
    }
}
