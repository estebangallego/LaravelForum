<?php

namespace Tests\Feature\Models;
use App\Models\Post;
use Tests\TestCase;
use Illuminate\Support\Str;

class PostTest extends TestCase
{
    public function test_title_case_for_title()
    {
        $post = Post::factory()->create(['title' => 'hello world']);
        $this->assertEquals('Hello World', $post->title);
    }

    public function test_generates_html_for_body()
    {
        $post = Post::factory()->make(['body' => '## hello world']);
        $post->save();

        // expect post body to be markdown
        $this->assertEquals($post->html, Str::markdown($post->body));
    }

}
