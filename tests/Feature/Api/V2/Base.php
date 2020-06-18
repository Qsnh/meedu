<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Api\V2;

use Tests\TestCase;

class Base extends TestCase
{
    protected function user($user)
    {
        return $this->actingAs($user, 'apiv2');
    }

    public function assertResponseError($response, $message = '')
    {
        $c = $response->response->getContent();
        $c = json_decode($c, true);
        $this->assertNotEquals(0, $c['code']);
        $message && $this->assertEquals($message, $c['message']);
    }

    public function assertResponseSuccess($response)
    {
        $c = $response->response->getContent();
        $c = json_decode($c, true);
        $this->assertEquals(0, $c['code']);
        return $c;
    }
}
