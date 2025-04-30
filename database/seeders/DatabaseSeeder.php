<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();
        $post = Post::factory(1)
            ->withFixture()
            ->has(Comment::factory(15)
                ->recycle($users))
            ->recycle($users)
            ->create();

        // WARNING: This is just for testing purposes
        if (! User::where('email', 'test@example.com')->exists()) {
            User::factory()
                ->has(Post::factory(45)->withFixture())
                ->has(Comment::factory(20)->recycle($post))
                ->create([
                    'name' => 'Esteban',
                    'email' => 'test@test.com',
                    'password' => bcrypt('password'),
                ]);
        }
    }
}
