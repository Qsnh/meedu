<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Bus;

use Tests\TestCase;
use App\Bus\WechatBindBus;
use Illuminate\Support\Str;
use App\Constant\FrontendConstant;
use App\Exceptions\ServiceException;
use App\Services\Member\Models\Socialite;

class WechatBindBusTest extends TestCase
{

    /**
     * @var WechatBindBus
     */
    protected $wechatBindBus;

    public function setUp(): void
    {
        parent::setUp();
        $this->wechatBindBus = $this->app->make(WechatBindBus::class);
    }

    public function test_isBind()
    {
        $this->assertTrue($this->wechatBindBus->isBind('bind_123'));
        $this->assertFalse($this->wechatBindBus->isBind('123'));
    }

    public function test_userId()
    {
        $this->assertEquals(1, $this->wechatBindBus->userId('bind_1'));
        $this->assertEquals(0, $this->wechatBindBus->userId('bind_'));
    }

    public function test_code()
    {
        $code = $this->wechatBindBus->code(1234);
        $this->assertEquals(1234, $this->wechatBindBus->userId($code));
    }

    public function test_qrcode()
    {
        config([
            'meedu.mp_wechat.app_id' => env('WECHAT_MP_APP_ID', ''),
            'meedu.mp_wechat.app_secret' => env('WECHAT_MP_APP_SECRET', ''),
            'meedu.mp_wechat.token' => env('WECHAT_MP_TOKEN', ''),
        ]);

        $data = $this->wechatBindBus->qrcode(1);

        $this->assertTrue(isset($data['code']));
        $this->assertTrue(isset($data['image']));
    }

    public function test_handle_with_error_code()
    {
        $this->expectException(ServiceException::class);
        $this->wechatBindBus->handle('bind', '123', []);
    }

    public function test_handle()
    {
        $userId = 123;

        $code = $this->wechatBindBus->code($userId);

        $appId = Str::random(10);
        $this->wechatBindBus->handle($code, $appId, []);

        $socialite = Socialite::query()
            ->where('user_id', $userId)
            ->where('app', FrontendConstant::WECHAT_LOGIN_SIGN)
            ->firstOrFail();

        $this->assertEquals($appId, $socialite['app_user_id']);
    }

    public function test_handle_with_has_bind()
    {
        $userId = 123;
        $appId = Str::random(10);

        Socialite::create([
            'user_id' => $userId,
            'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
            'app_user_id' => $appId,
        ]);

        $code = $this->wechatBindBus->code($userId);

        $this->expectExceptionMessage(__('您已经绑定了该渠道的账号'));
        $this->wechatBindBus->handle($code, $appId, []);
    }

    public function test_handle_with_other_bind()
    {
        $userId = 123;
        $appId = Str::random(10);

        Socialite::create([
            'user_id' => $userId + 1,
            'app' => FrontendConstant::WECHAT_LOGIN_SIGN,
            'app_user_id' => $appId,
        ]);

        $code = $this->wechatBindBus->code($userId);

        $this->expectExceptionMessage(__('当前渠道账号已绑定了其它账号'));
        $this->wechatBindBus->handle($code, $appId, []);
    }
}
