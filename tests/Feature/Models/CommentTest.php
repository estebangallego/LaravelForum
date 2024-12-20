<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use Tests\TestCase;
use Illuminate\Support\Str;


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
