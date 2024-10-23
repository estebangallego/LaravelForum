<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\User;

class EditCommentsTest extends TestCase
{
    use RefreshDatabase;
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    // Edit comments requires authentication
    public function test_it_requires_authentication()
    {
        $comment = Comment::factory()->create();
        $response = $this->put(route('comments.update', $comment));
        $response->assertRedirect(route('login')); 
    }

    // Can update comments
    public function test_can_update_comments() 
    {

        $comment = Comment::factory()->for($this->user)->create(['body' => 'This is a test comment']);
        $commentUpdate = 'This is an updated comment';
        $this->actingAs($this->user)->put(route('comments.update', $comment), [
            'body' => $commentUpdate,
        ]);
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'body' => $commentUpdate,
        ]);
    }

    // Redirects to post show page with pagination
    public function test_redirects_to_post_show_page() 
    {
        $comment = Comment::factory()->for($this->user)->create();
        $response = $this->actingAs($this->user)->put(route('comments.update', $comment), [
            'body' => 'This is an updated comment',
        ]);
        $response->assertRedirect(route('posts.show', $comment->post));
    }


    // Can not update comments that are not yours
    public function test_cannot_update_comments_that_are_not_yours() 
    {
        $newUser = User::factory()->create();
        $comment = Comment::factory()->for($newUser)->create();

        $commentUpdate = 'This is an updated comment';
        $response = $this->actingAs($this->user)->put(route('comments.update', $comment), [
            'body' => $commentUpdate,
        ]);
        $response->assertForbidden();
    }

    // Validate comments
    public function test_validate_comments() 
    {
        $comment = Comment::factory()->for($this->user)->create();
        $invalidInputs = [
            '' => 'The body field is required.',
            null => 'The body field is required.',
            1 => 'The body field must be a string.',
            str_repeat('a', 2501) => 'The body field must not be greater than 2500 characters.',
            true => 'The body field must be a string.',
        ];

        foreach ($invalidInputs as $input => $message) {
            $response = $this->actingAs($this->user)->put(route('comments.update', $comment), [
                'body' => $input,
            ]);

            $response->assertInvalid(['body' => [$message]]);
        }
    }
}
