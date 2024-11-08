<?php

namespace Tests\Feature\Controllers\PostController;

use Tests\TestCase;

class CreateTest extends TestCase
{

    public function test_it_requires_authentication()
    {
        $this->get(route('posts.create'))->assertRedirect(route('login')); 
    }
}
