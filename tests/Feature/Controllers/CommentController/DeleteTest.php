<?php

namespace Tests\Feature\Controllers\CommentController;

use App\Models\Comment;
use Tests\TestCase;
use App\Models\User;

class DeleteTest extends TestCase
{
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }


    public function test_require_auth()
    {
        $comment = Comment::factory()->create();
        $response = $this->delete(route('comments.destroy', $comment));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_delete_comment()
    {
        $comment = Comment::factory()->for($this->user)->create();
        $response = $this->actingAs($this->user)->delete(route('comments.destroy', $comment));
        $this->assertModelMissing($comment);
        $response->assertRedirect(route('posts.show', $comment->post));
    }

    public function test_prevent_users_from_deleting_others_comments()
    {
        $comment = Comment::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('comments.destroy', $comment));
        $response->assertForbidden();
    }

    public function test_prevents_deleting_comments_after_an_hour()
    {   
        $this->freezeTime();
        $comment = Comment::factory()->for($this->user)->create();
        $this->travel(1)->hour();
        $response = $this->actingAs($this->user)->delete(route('comments.destroy', $comment));
        $response->assertForbidden();
    }

    public function test_redirects_to_post_with_the_pagination()
    {
        $comment = Comment::factory()->for($this->user)->create();
        $response = $this->actingAs($this->user)->delete(
            route('comments.destroy', ['comment' => $comment, 'page' => 2]),
        );
        $response->assertRedirect(
            route('posts.show', ['post' => $comment->post, 'page' => 2])
        );
    }
}


