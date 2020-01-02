<?php


namespace Tests\Feature\Page;


use App\Services\Member\Models\Socialite;
use App\Services\Member\Models\User;
use Illuminate\Support\Str;
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
        config(['meedu.member.socialite.weixinweb.enabled' => 1]);
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.socialite'))
            ->seeStatusCode(200)
            ->dontSee('Wechat')
            ->see('qq');
    }

    public function test_cancel_button()
    {
        $user = factory(User::class)->create();
        Socialite::create([
            'user_id' => $user->id,
            'app' => 'qq',
            'app_user_id' => Str::random(),
            'data' => '',
        ]);
        $this->actingAs($user)
            ->visit(route('member.socialite'))
            ->seeStatusCode(200)
            ->see('取消');
    }

}