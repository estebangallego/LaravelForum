<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use Illuminate\Support\Str;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_generates_html_for_body()
    {
        $comment = Comment::factory()->make(['body' => '## hello world']);
        $comment->save();

        // expect post body to be markdown
        $this->assertEquals($comment->html, Str::markdown($comment->body));
    }
}
