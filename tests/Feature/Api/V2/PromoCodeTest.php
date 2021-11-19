<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V2;

use App\Services\Member\Models\User;
use App\Services\Order\Models\PromoCode;

class PromoCodeTest extends Base
{
    public function test_detail()
    {
        $promoCode = PromoCode::factory()->create(['code' => 1234]);
        $response = $this->getJson('/api/v2/promoCode/' . $promoCode->code);
        $res = $this->assertResponseSuccess($response);
        $this->assertEquals($promoCode->code, $res['data']['code']);
    }

    public function test_check()
    {
        $user = User::factory()->create();
        $promoCode = PromoCode::factory()->create(['code' => 1234]);
        $response = $this->user($user)->getJson('/api/v2/promoCode/' . $promoCode->code . '/check');
        $res = $this->assertResponseSuccess($response);
        $this->assertEquals(1, $res['data']['can_use']);
    }
}
