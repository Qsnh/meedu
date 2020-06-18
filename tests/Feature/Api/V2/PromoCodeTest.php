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

use App\Services\Member\Models\User;
use App\Services\Order\Models\PromoCode;

class PromoCodeTest extends Base
{
    public function test_detail()
    {
        $promoCode = factory(PromoCode::class)->create(['code' => 1234]);
        $response = $this->getJson('/api/v2/promoCode/' . $promoCode->code);
        $res = $this->assertResponseSuccess($response);
        $this->assertEquals($promoCode->code, $res['data']['code']);
    }

    public function test_check()
    {
        $user = factory(User::class)->create();
        $promoCode = factory(PromoCode::class)->create(['code' => 1234]);
        $response = $this->user($user)->getJson('/api/v2/promoCode/' . $promoCode->code . '/check');
        $res = $this->assertResponseSuccess($response);
        $this->assertEquals(1, $res['data']['can_use']);
    }
}
