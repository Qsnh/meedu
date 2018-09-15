<?php

namespace Tests\Feature\Page;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterPage extends TestCase
{

    public function test_visit()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
        $response->assertSee('注册');
        $response->assertSee('登陆');
    }

}
