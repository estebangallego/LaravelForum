<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_controller(): void
    {
        $response = $this->get(route("posts.index"));

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Posts/Index', true)
        );
        
        $response->assertStatus(200);
    }

    public function test_index_posts(): void
    {
        $response = $this->get(route("posts.index"));

        $response->assertInertia(fn (Assert $inertia) => $inertia
            ->has("posts")
        );
        
    }
}
