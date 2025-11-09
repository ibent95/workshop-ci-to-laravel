<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Root database seeder.
 *
 * @category Seeders
 * @package  Database\Seeders
 * @author   Your Name <example@example.com>
 * @license  MIT License
 * @link     https://example.com
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create(
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]
        );

        Post::factory(15)->create();
    }
}
