<?php

namespace Tests\Feature\Controllers\PostController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_store_post()
    {
        $data = [
            'title' => 'This is a test post',
            'body' => 'This is a test post body',
        ];

        $this->actingAs($this->user)
            ->post(route('posts.store'), $data)
            // ->assertSuccessful()
            ->assertRedirect(route('posts.show', Post::latest('id')->first()));  
        
        $this->assertDatabaseHas(Post::class, $data);
    }

}
