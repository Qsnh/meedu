<?php


namespace Tests\Feature\Page;


use App\Services\Member\Models\Socialite;
use App\Services\Member\Models\User;
use Tests\TestCase;

class MemberSocialiteTest extends TestCase
{

    public function test_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)->visit(route('member.socialite'))->seeStatusCode(200);
    }

    public function test_enabled_app()
    {
        config(['meedu.member.socialite.qq.enabled' => 1]);
        config(['meedu.member.socialite.weixinweb.enabled' => 0]);
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.socialite'))
            ->seeStatusCode(200)
            ->dontSee('Wechat')
            ->see('Qq');
    }

    public function test_cancel_button()
    {
        config(['meedu.member.socialite.github.enabled' => 1]);
        config(['meedu.member.socialite.qq.enabled' => 1]);
        config(['meedu.member.socialite.weixinweb.enabled' => 1]);
        $user = factory(User::class)->create();
        factory(Socialite::class)->create([
            'user_id' => $user->id,
            'app' => 'qq',
        ]);
        $this->actingAs($user)
            ->visit(route('member.socialite'))
            ->seeStatusCode(200)
            ->see('取消');
    }

}