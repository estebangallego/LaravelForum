<?php

namespace Tests\Feature;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Topic;
use App\Http\Resources\TopicResource;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_controller(): void
    {
        $response = $this->get(route('posts.index'));
        $response->assertComponent('Posts/Index', true);
        $response->assertStatus(200);
    }

    public function test_index_posts(): void
    {
        $posts = Post::factory(3)->create();
        $posts->load(['user', 'topic']);
        $response = $this->get(route('posts.index'));
        $response->assertPaginatedResource('posts', PostResource::collection($posts->reverse()));
    }

    public function test_index_topics(): void
    {
        $general = Topic::factory()->create();
        $posts = Post::factory(3)->for($general)->create();

        $posts->load(['user', 'topic']);

        $response = $this->get(route('posts.index', ['topic' => $general]));
        $response->assertPaginatedResource('posts', PostResource::collection($posts->reverse()));
    }

    public function test_index_passes_topic_to_view(): void
    {
        $topic = Topic::factory()->create();

        $response = $this->get(route('posts.index', ['topic' => $topic]));
        $response->assertHasResource('selectedTopic', TopicResource::make($topic));
    }
}
