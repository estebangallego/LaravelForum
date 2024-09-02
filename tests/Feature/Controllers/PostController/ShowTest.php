<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Http\Resources\CommentResource;

class ShowTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_show_page(): void
    {
        $post = Post::factory(1)->create();
        $post->load('user');
        $response = $this->get(route('posts.show', $post->first()));
        $response->assertComponent('Posts/Show', true);
        $response->assertHasResource("post", PostResource::make($post->first()));
        $response->assertStatus(200);
    }


    public function test_passes_comments_to_view(): void
    {
        $this->withoutExceptionHandling();
        $post = Post::factory()->create();
        $comments = Comment::factory(3)->for($post)->create();
        $comments->load('user');

        $response = $this->get(route("posts.show", $post->first()));
        $response->assertPaginatedResource("comments", CommentResource::collection($comments->reverse()));
    }

}
