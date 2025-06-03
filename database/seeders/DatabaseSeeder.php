<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Like;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TopicSeeder::class,
        ]);

        $topics = Topic::all();

        $users = User::factory(10)->create();
        $posts = Post::factory(200)
            ->withFixture()
            ->has(Comment::factory(15)->recycle($users))
            ->recycle([$users, $topics])
            ->create();

        // WARNING: This is just for testing purposes
        if (! User::where('email', 'test@example.com')->exists()) {
            User::factory()
                ->has(Post::factory(45)->recycle($topics)->withFixture())
                ->has(Comment::factory(20)->recycle($posts))
                ->has(Like::factory()->forEachSequence(
                    ...$posts->random(100)->map(fn (Post $post) => ['likeable_id' => $post])
                ))
                ->create([
                    'name' => 'Esteban',
                    'email' => 'test@test.com',
                    'password' => bcrypt('password'),
                ]);
        }
    }
}
