<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PerformanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks for clean truncation
        Schema::disableForeignKeyConstraints();
        Post::truncate();
        Category::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $this->command->info('Creating 10 users...');
        $users = User::factory()->count(10)->create();

        $this->command->info('Creating 15 root categories...');
        $rootCategories = Category::factory()->count(15)->create();

        $this->command->info('Creating 35 subcategories...');
        $subCategories = collect();
        for ($i = 0; $i < 35; $i++) {
            $subCategories->push(
                Category::factory()->create([
                    'parent_id' => $rootCategories->random()->id
                ])
            );
        }

        $allCategories = $rootCategories->concat($subCategories);

        $this->command->info('Creating 100,000 posts distributed across categories...');
        
        // Chunking the post creation to prevent memory exhaustion
        $totalPosts = 100000;
        $chunkSize = 5000;

        for ($i = 0; $i < $totalPosts; $i += $chunkSize) {
            $postsToCreate = [];
            
            for ($j = 0; $j < $chunkSize; $j++) {
                $title = fake()->sentence(rand(4, 10));
                $postsToCreate[] = [
                    'user_id' => $users->random()->id,
                    'category_id' => $allCategories->random()->id,
                    'title' => substr($title, 0, 500),
                    'slug' => substr(\Illuminate\Support\Str::slug($title), 0, 200) . '-' . uniqid(),
                    'content' => fake()->paragraphs(rand(3, 7), true),
                    'excerpt' => fake()->sentence(rand(8, 15)),
                    'cover_image' => null,
                    'status' => fake()->randomElement(['draft', 'published', 'archived']),
                    'views' => rand(0, 15000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Post::insert($postsToCreate);

            $this->command->info("Seeded " . ($i + $chunkSize) . " / {$totalPosts} posts...");
        }

        $this->command->info('Database seeding completed successfully!');
    }
}
