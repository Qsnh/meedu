<?php

namespace Tests\Feature\Page;

use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
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

    public function test_submit()
    {
        $user = factory(User::class)->create([
            'mobile' => '12398762345',
            'password' => Hash::make('meedu123'),
        ]);

        $this->session(['sms_password_reset' => 'smscode']);

        $this->visit(route('password.request'))
            ->type($user->mobile, 'mobile')
            ->type('smscode', 'sms_captcha')
            ->type('password_reset', 'sms_captcha_key')
            ->type('123123', 'password')
            ->type('123123', 'password_confirmation')
            ->press('重置密码')
            ->seePageIs('login');

        $user->refresh();
        $this->assertTrue(Hash::check('123123', $user->password));
    }

}
