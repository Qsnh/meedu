<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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


    public function assertResponseSuccess($request)
    {
        /**
         * @var \Laravel\BrowserKitTesting\TestResponse $response
         */
        $response = $request->response;

        $this->assertEquals(200, $response->getStatusCode());

        $c = $response->getContent();
        $c = json_decode($c, true);
        $this->assertEquals(0, $c['code']);
        return $c;
    }
}
