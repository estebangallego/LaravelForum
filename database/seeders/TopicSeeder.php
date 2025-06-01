<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'General',
                'description' => 'General discussion about the forum.',
                'slug' => 'general',
            ],
            [
                'name' => 'Reviews',
                'description' => 'Reviews of products, services, and other things.',
                'slug' => 'reviews',
            ],
            [
                'name' => 'Questions',
                'description' => 'Questions about the forum.',
                'slug' => 'questions',
            ],
            [
                'name' => 'Announcements',
                'description' => 'Announcements about the forum.',
                'slug' => 'announcements',
            ],
            [
                'name' => 'Conspiracy Theories',
                'description' => 'Conspiracy theories and discussions.',
                'slug' => 'conspiracy-theories',
            ],
            [
                'name' => 'Gaming',
                'description' => 'Gaming discussion.',
                'slug' => 'gaming',
            ],
            [
                'name' => 'Technology',
                'description' => 'Technology discussion.',
                'slug' => 'technology',
            ],
        ];

        foreach ($data as $topic) {
            Topic::upsert($topic, ['slug']);
        }
    }
}
