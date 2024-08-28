<?php

namespace Tests\Feature;

use App\Http\Resources\CommentResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Assert as PHPUnit;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use App\Http\Resources\PostResource;
use App\Models\Post;



class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_controller(): void
    {
        $response = $this->get(route("posts.index"));
        $response->assertComponent('Posts/Index', true);
        $response->assertStatus(200);
    }

    public function test_index_posts(): void
    {
        $posts = Post::factory(3)->create();
        $posts->load('user');
        $response = $this->get(route("posts.index"));
        $response->assertPaginatedResource("posts", PostResource::collection($posts->reverse()));
    }
}
