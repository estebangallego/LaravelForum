<?php

namespace Tests\Feature\Controllers\CommentController;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_store_comment()
    {
        $post = Post::factory()->create();

        $response = $this->actingAs($this->user)
            ->post(route('posts.comments.store', $post), [
                'body' => 'This is a test comment',
            ]);

        $response->assertRedirect($post->showRoute());
        $this->assertDatabaseHas(Comment::class, [
            'post_id' => $post->id,
            'user_id' => $this->user->id,
            'body' => 'This is a test comment',
        ]);
    }

    public function test_requires_authenticated_user_to_store_comment()
    {

        $response = $this->post(route('posts.comments.store', Post::factory()->create()), [
            'body' => 'This is a test comment',
        ]);

        $response->assertRedirect(route('login'));
    }
}
