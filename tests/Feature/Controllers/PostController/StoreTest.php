<?php

namespace Tests\Feature\Controllers\PostController;

use App\Models\Post;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected array $validData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->validData = [
            'title' => Faker::create()->sentence(),
            'body' => Faker::create()->sentence(),
        ];
    }

    public function test_it_requires_authentication()
    {
        $this->post(route('posts.store'))->assertRedirect(route('login'));
    }

    public function test_store_post()
    {
        $post = $this->actingAs($this->user)
            ->post(route('posts.store'), $this->validData);

        $post->assertRedirect(Post::latest('id')->first()->showRoute());

        $this->assertDatabaseHas(Post::class, [
            ...$this->validData,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_store_post_with_invalid_data()
    {
        $invalidTitle = ['', null, 1, true, str_repeat('a', 256)];
        foreach ($invalidTitle as $data) {
            $this->actingAs($this->user)
                ->post(route('posts.store'), [
                    'title' => $data,
                    'body' => Faker::create()->sentence(),
                    'user_id' => $this->user->id,
                ])
                ->assertInvalid(['title']);
        }

        $invalidBody = ['', null, 1, true, str_repeat('a', 2501)];
        foreach ($invalidBody as $data) {
            $this->actingAs($this->user)
                ->post(route('posts.store'), [
                    'title' => Faker::create()->sentence(),
                    'body' => $data,
                    'user_id' => $this->user->id,
                ])
                ->assertInvalid(['body']);
        }
    }
}
