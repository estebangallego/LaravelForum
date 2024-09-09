<?php

namespace Tests\Feature\Controllers\PostController;

use App\Models\Comment;
use Tests\TestCase;
use App\Models\User;

class DeleteTest extends TestCase
{
    public function test_require_auth()
    {
        $comment = Comment::factory()->create();
        $response = $this->delete(route('comments.destroy', $comment));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_delete_comment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->for($user)->create();
        $response = $this->actingAs($user)->delete(route('comments.destroy', $comment));
        $this->assertModelMissing($comment);
        $response->assertRedirect(route('posts.show', $comment->post));
    }

}
