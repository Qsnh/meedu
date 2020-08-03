<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Services\Base;

use Tests\TestCase;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class ConfigServiceTest extends TestCase
{

    /**
     * @var ConfigService
     */
    protected $service;

    public function setUp():void
    {
        parent::setUp();
        $this->service = $this->app->make(ConfigServiceInterface::class);
    }


    public function test_getSms()
    {
        $this->assertEquals(config('sms'), $this->service->getSms());
    }

    public function test_getWechatPay()
    {
        $this->assertEquals(config('pay.wechat'), $this->service->getWechatPay());
    }

    public function test_getAlipayPay()
    {
        $this->assertEquals(config('pay.alipay'), $this->service->getAlipayPay());
    }
}
