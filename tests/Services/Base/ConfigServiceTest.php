<?php


namespace Tests\Services\Base;


use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Base\Services\ConfigService;
use Tests\TestCase;

class ConfigServiceTest extends TestCase
{

    /**
     * @var ConfigService
     */
    protected $service;

    public function setUp()
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