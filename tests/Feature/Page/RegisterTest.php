<?php

namespace Tests\Feature\Page;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{

    public function test_visit()
    {
        $response = $this->get(route('register'));
        $response->assertResponseStatus(200);
        $response->see('注册');
        $response->see('登录');
    }

}
