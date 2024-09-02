<?php

namespace Tests\Feature\Controllers\CommentController;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class StoreTest extends TestCase
{
    public function test_store_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        
        $response = $this->actingAs($user)
            ->post(route('posts.comments.store', $post), [
                'body' => 'This is a test comment',
            ]);

        $response->assertRedirect(route('posts.show', $post));
        $this->assertDatabaseHas(Comment::class, [
            'post_id' => $post->id,
            'user_id'=> $user->id,
            'body'=> 'This is a test comment',
        ]);
    }

    public function test_requires_authenticated_user_to_store_comment() {
        
        $response = $this->post(route('posts.comments.store', Post::factory()->create()), [
            'body'=> 'This is a test comment',
        ]);

       $response->assertRedirect(route('login'));
    }
}
