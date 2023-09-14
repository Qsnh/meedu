<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Other;

use Tests\TestCase;
use App\Meedu\Sms\SmsInterface;
use App\Services\Other\Services\SmsService;
use App\Services\Other\Interfaces\SmsServiceInterface;

class SmsServiceTest extends TestCase
{

    /**
     * @var SmsService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(SmsServiceInterface::class);
    }

    public function test_send()
    {
        // mock
        $mockObj = \Mockery::mock(SmsInterface::class);
        $mockObj->shouldReceive('sendCode');

        app()->instance(SmsInterface::class, $mockObj);

        $this->service->sendCode('13899990001', '123123', 'register');
        $this->service->sendCode('13899990001', '123123', 'password_reset');
        $this->service->sendCode('13899990001', '123123', 'login');
        $this->service->sendCode('13899990001', '123123', 'mobile_bind');
    }
}
