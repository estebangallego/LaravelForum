<?php

namespace Tests\Feature\Controllers\LikeController;

use App\Models\User;
use App\Models\Post;
use App\Models\Like;
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
    public function test_it_requires_authentication()
    {
        $post = Post::factory()->create();
        $this->post(route('likes.store', [
            'type' => $post->getMorphClass(),
            'id' => $post->getKey()
        ]))->assertRedirect(route('login'));
    }

    public function test_allow_liking_a_likeable()
    {
        $post = Post::factory()->create();
        
        $this->actingAs($this->user)
            ->fromRoute('dashboard')
            ->post("/likes/{$post->getMorphClass()}/{$post->getKey()}")
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('likes', [
            'likeable_type' => $post->getMorphClass(),
            'likeable_id' => $post->getKey(),
            'user_id' => $this->user->id,
        ]);

        $this->assertDatabaseCount('likes', 1);
    }

    public function test_prevent_liking_a_likeable_twice()
    {
        $post = Post::factory()->create();
        // Create an existing like
        Like::create([
            'user_id' => $this->user->id,
            'likeable_id' => $post->id,
            'likeable_type' => $post->getMorphClass(),
        ]);

        // Attempt to like again
        $this->actingAs($this->user)
            ->post(route('likes.store', [
                'type' => $post->getMorphClass(),
                'id' => $post->id,
            ]))
            ->assertForbidden();

        $this->assertDatabaseCount('likes', 1);
    }

    public function test_only_allow_liking_supported_models()
    {
        $this->actingAs($this->user)
            ->post(route('likes.store', [
                $this->user->getMorphClass(),
                $this->user->id
            ]))->assertForbidden();
    }

    public function test_trows_a_404_if_type_is_not_supported()
    {
        $this->actingAs($this->user)
            ->post(route('likes.store', [
                'type' => 'unsupported',
                'id' => 1,
            ]))->assertNotFound();
    }
}
