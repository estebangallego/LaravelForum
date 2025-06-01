<?php

namespace Tests\Feature\Controllers\PostController;

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected \Closure $validData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->validData = fn () => [
            'title' => Faker::create()->sentence(),
            'topic_id' => Topic::factory()->create()->getKey(),
            'body' => Faker::create()->paragraph(),
        ];
    }

    public function test_it_requires_authentication()
    {
        $this->post(route('posts.store'))->assertRedirect(route('login'));
    }

    public function test_store_post()
    {
        $data = $this->validData->call($this);
        $post = $this->actingAs($this->user)
            ->post(route('posts.store'), $data);
        $post->assertRedirect(Post::latest('id')->first()->showRoute());

        $this->assertDatabaseHas(Post::class, [
            ...$data,
        ]);
    }

    public function test_store_post_with_invalid_data()
    {
        $this->actingAs($this->user)
            ->post(route('posts.store'), [
                'title' => '',
                'body' => '',
                'topic_id' => '',
            ])
            ->assertInvalid(['title', 'body', 'topic_id']);

        $this->actingAs($this->user)
            ->post(route('posts.store'), [
                'title' => Faker::create()->sentence(),
                'body' => Faker::create()->paragraph(),
                'topic_id' => 'invalid-topic-id',
            ])
            ->assertInvalid(['topic_id']);

        $this->actingAs($this->user)
            ->post(route('posts.store'), [
                'title' => Faker::create()->sentence(),
                'body' => Faker::create()->paragraph(),
                'topic_id' => -1,
            ])
            ->assertInvalid(['topic_id']);
    }
}
