<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Assert as PHPUnit;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_controller(): void
    {
        $response = $this->get(route("posts.index"));

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Posts/Index', true)
        );
        
        $response->assertStatus(200);
    }

    public function test_index_posts(): void
    {
        $posts = Post::factory(3)->create();
        $response = $this->get(route("posts.index"));
        $response->assertInertia(fn (Assert $inertia) => $inertia
            // ->hasResource("post", PostResource::make($posts->first()))
            ->hasPaginateResource("posts", PostResource::collection($posts->reverse()))
        );
        
    }
}
