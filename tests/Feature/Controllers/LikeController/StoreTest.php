<?php

namespace Tests\Feature\Controllers\LikeController;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

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
}
