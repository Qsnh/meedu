<?php

namespace Tests\Feature\Page;

use Tests\TestCase;

class FindPasswordTest extends TestCase
{

    // 测试找回密码
    public function test_visit()
    {
        $this->get(route('password.request'))
            ->assertResponseStatus(200)
            ->see('手机号')
            ->seeInElement('button', '重置密码');
    }

}
