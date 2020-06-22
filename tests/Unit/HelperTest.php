<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Unit;

use Exception;
use Tests\TestCase;

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
}
