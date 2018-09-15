<?php

namespace Tests\Feature\Page;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{

    public function test_visit_login_page()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertSeeText('登陆');
        $response->assertSeeText('忘记密码');
        $response->assertSeeText('注册');
    }

}
