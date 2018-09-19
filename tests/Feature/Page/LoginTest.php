<?php

namespace Tests\Feature\Page;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{

    public function test_visit_login_page()
    {
        $response = $this->get(route('login'));
        $response->assertResponseStatus(200);
        $response->see('登陆');
        $response->see('忘记密码');
        $response->see('注册');
    }

}
