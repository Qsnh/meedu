<?php

namespace Tests\Feature\Page;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FindPasswordTest extends TestCase
{

    // 测试找回密码
    public function test_visit()
    {
        $this->get(route('password.request'))->assertResponseStatus(200);
    }

}
