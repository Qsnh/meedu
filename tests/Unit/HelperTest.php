<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Constant\CacheConstant;

class HelperTest extends TestCase
{
    public function test_exception_record()
    {
        try {
            throw new Exception('我是异常');
        } catch (Exception $exception) {
            exception_record($exception);
        }
        $this->assertFalse(false);
    }

    public function test_is_wechat()
    {
        $this->assertFalse(is_wechat());
    }

    public function test_is_h5()
    {
        $this->assertFalse(is_h5());
    }

    public function test_duration_humans()
    {
        $this->assertEquals('00:01', duration_humans(1));
        $this->assertEquals('00:29', duration_humans(29));
        $this->assertEquals('01:01', duration_humans(61));
        $this->assertEquals('03:59', duration_humans(239));
        $this->assertEquals('01:00:01', duration_humans(3601));
        $this->assertEquals('01:01:01', duration_humans(3661));
    }

    public function test_array_compress()
    {
        $arr = [
            1 => [
                1 => 1,
                2 => 2,
            ],
        ];
        $arr = array_compress($arr);
        $this->assertEquals(1, $arr['1.1']);
        $this->assertEquals(2, $arr['1.2']);
    }

    public function test_random_number()
    {
        $str = random_number('C', 10);
        $this->assertEquals(10, mb_strlen($str));
    }

    public function test_mobile_code_check()
    {
        /**
         * @var $cacheService \App\Services\Base\Services\CacheService
         */
        $cacheService = app()->make(\App\Services\Base\Interfaces\CacheServiceInterface::class);

        $this->assertFalse(mobile_code_check(null, null), '空参数返回false');
        $this->assertFalse(mobile_code_check('13899990002', ''), '空参数返回false');
        $this->assertFalse(mobile_code_check('', '123123'), '空参数返回false');

        $this->assertFalse(mobile_code_check('13899990002', '112233'), 'testing环境固定验证码112233无效');

        $mobile = '13899990002';
        $mobileCodeKey = get_cache_key(\App\Constant\CacheConstant::MOBILE_CODE['name'], $mobile);
        $mobileCodeSafeKey = get_cache_key(\App\Constant\CacheConstant::MOBILE_CODE_SAFE['name'], $mobile);

        $cacheService->put($mobileCodeKey, '123321', CacheConstant::MOBILE_CODE['expire']);
        $this->assertTrue(mobile_code_check($mobile, '123321'));
        // 校验超过之后原先验证码销毁
        $this->assertEmpty($cacheService->get($mobileCodeKey));
        $this->assertEmpty($cacheService->get($mobileCodeSafeKey));

        // 校验失败1次之后校验超过
        $cacheService->put($mobileCodeKey, '123456', CacheConstant::MOBILE_CODE['expire']);
        $this->assertFalse(mobile_code_check($mobile, '123321'));
        $this->assertEquals(1, (int)$cacheService->get($mobileCodeSafeKey));
        $this->assertTrue(mobile_code_check($mobile, '123456'));
        $this->assertEmpty($cacheService->get($mobileCodeKey));
        $this->assertEmpty($cacheService->get($mobileCodeSafeKey));

        // 校验失败5次之后校验超过
        $cacheService->put($mobileCodeKey, '190929', CacheConstant::MOBILE_CODE['expire']);
        for ($i = 1; $i <= 5; $i++) {
            $this->assertFalse(mobile_code_check($mobile, '123321'));
            $this->assertEquals($i, (int)$cacheService->get($mobileCodeSafeKey));
        }
        $this->assertTrue(mobile_code_check($mobile, '190929'));
        $this->assertEmpty($cacheService->get($mobileCodeKey));
        $this->assertEmpty($cacheService->get($mobileCodeSafeKey));

        // 校验失败10次之后校验成功
        $cacheService->put($mobileCodeKey, '189890', CacheConstant::MOBILE_CODE['expire']);
        for ($i = 1; $i <= 10; $i++) {
            $this->assertFalse(mobile_code_check($mobile, '123321'));
            $this->assertEquals($i, (int)$cacheService->get($mobileCodeSafeKey));
        }
        $this->assertTrue(mobile_code_check($mobile, '189890'));
        $this->assertEmpty($cacheService->get($mobileCodeKey));
        $this->assertEmpty($cacheService->get($mobileCodeSafeKey));

        // 校验失败11次之后原先验证码失效
        $cacheService->put($mobileCodeKey, '289800', CacheConstant::MOBILE_CODE['expire']);
        for ($i = 1; $i <= 11; $i++) {
            $this->assertFalse(mobile_code_check($mobile, '123321'));
            // 第11次错误校验导致数据被清空
            if ($i === 11) {
                $this->assertEmpty($cacheService->get($mobileCodeSafeKey));
            } else {
                $this->assertEquals($i, (int)$cacheService->get($mobileCodeSafeKey));
            }
        }
        // 超过11次就算第11次给出了正确的验证码也是失败的
        // 因为正确的验证码已经被清空了
        $this->assertFalse(mobile_code_check($mobile, '289800'));
        $this->assertEmpty($cacheService->get($mobileCodeKey));
        $this->assertEquals(1, (int)$cacheService->get($mobileCodeSafeKey));
    }
}
