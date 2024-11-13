<?php

namespace Tests\Feature\Controllers\CommentController;

use App\Models\Comment;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;
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
        $response->assertRedirect($comment->post->showRoute());
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
            $comment->post->showRoute(['page' => 2]),
        );
    }
}


