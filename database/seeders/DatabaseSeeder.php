<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

use Carbon\Factory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory(10)->create();
        $post = Post::factory(100)->recycle($user)->create();
        Comment::factory(100)->recycle($user)->recycle($post)->create();

        // WARNING: This is just for testing purposes
        if (!User::where('email', 'test@example.com')->exists()) {
                User::factory()
                    ->has(Post::factory(45))
                    ->has(Comment::factory(20)->recycle($post) )
                    ->create([
                        'name' => 'Esteban',
                        'email' => 'test@test.com',
                        'password'=> bcrypt('password'),
                    ]);
        }


    }
}
