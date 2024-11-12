<?php

namespace Tests\Feature\Models;
use App\Models\Post;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function test_title_case_for_title()
    {
        $post = Post::factory()->create(['title' => 'hello world']);
        $this->assertEquals('Hello World', $post->title);
    }

}
