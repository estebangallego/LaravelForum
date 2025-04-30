<?php

namespace Tests\Feature;

use App\Http\Resources\PostResource;
use App\Models\Post;
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
        $posts->load('user');
        $response = $this->get(route('posts.index'));
        $response->assertPaginatedResource('posts', PostResource::collection($posts->reverse()));
    }
}
