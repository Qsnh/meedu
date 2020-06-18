<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public $baseUrl = 'http://127.0.0.1:8000';

    public function assertResponseError($response, $message)
    {
        $responseContent = $response->getContent();
        $responseContent = json_decode($responseContent, true);
        $this->assertEquals($message, $responseContent['message']);
    }

    public function assertResponseAjaxSuccess($response)
    {
        $responseContent = $response->getContent();
        $responseContent = json_decode($responseContent, true);
        $this->assertEquals(0, $responseContent['code']);
    }
}
