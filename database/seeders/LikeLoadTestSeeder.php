<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\LazyCollection;

class LikeLoadTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post = Post::find(1);
        $progressBar = $this->command->getOutput()->createProgressBar(500_000);
        $progressBar->start();
        
        LazyCollection::times(5000)->each(function () use ($post, $progressBar) {
            Like::factory(100)->for($post, 'likeable')->create();
            $progressBar->advance(100);
        });

        $progressBar->finish();
        $post->increment('likes_count', 500_000);
    }
}
