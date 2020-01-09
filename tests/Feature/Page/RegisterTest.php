<?php

namespace Tests\Feature\Page;

use Tests\TestCase;

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
