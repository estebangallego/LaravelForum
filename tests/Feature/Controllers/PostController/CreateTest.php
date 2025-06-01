<?php

namespace Tests\Feature\Controllers\PostController;

use App\Http\Resources\TopicResource;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected array $validData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_it_requires_authentication()
    {
        $this->get(route('posts.create'))->assertRedirect(route('login'));
    }

    public function test_component()
    {

        $this->actingAs($this->user)
            ->get(route('posts.create'))
            ->assertComponent('Posts/Create');

    }

    public function test_passes_topics_to_the_view()
    {
        $topics = Topic::factory(2)->create();
        $this->actingAs($this->user)
            ->get(route('posts.create'))
            ->assertHasResource('topics', TopicResource::collection($topics));
    }
}
