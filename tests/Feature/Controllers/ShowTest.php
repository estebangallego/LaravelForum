<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Post;
use App\Http\Resources\PostResource;

class ShowTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_show_page(): void
    {
        $post = Post::factory(1)->create();
        $response = $this->get(route('posts.show', $post->first()));
        $response->assertComponent('Posts/Show', true);
        $response->assertHasResource("post", PostResource::make($post->first()));
        $response->assertStatus(200);
    }
}
