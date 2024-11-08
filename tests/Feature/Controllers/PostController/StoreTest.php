<?php

namespace Tests\Feature\Controllers\PostController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use Faker\Factory as Faker;
use Illuminate\Support\Testing\Fakes\Fake;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected array $validData;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->validData = [
            'title' => Faker::create()->sentence(),
            'body' => Faker::create()->sentence(),
        ];
    }

    public function test_store_post()
    {
        $this->actingAs($this->user)
            ->post(route('posts.store'), $this->validData)
            ->assertRedirect(route('posts.show', Post::latest('id')->first()));
    
        $this->assertDatabaseHas(Post::class, [
            ...$this->validData,
            'user_id' => $this->user->id
        ]);
    }

    public function test_store_post_with_invalid_data()
    {
        $invalidData = ['', null, 1, true, str_repeat('a', 256)];

        foreach ($invalidData as $data) {
            $this->actingAs($this->user)
            ->post(route('posts.store'), [
                'title' => $data,
                'body' => Faker::create()->sentence(),
                'user_id' => $this->user->id
            ])
            ->assertInvalid(['title']);      
        }

    }

}
