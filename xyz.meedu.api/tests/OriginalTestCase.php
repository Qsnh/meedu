<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests;

use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class OriginalTestCase extends \Illuminate\Foundation\Testing\TestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * @param TestResponse $response
     * @return array
     */
    public function assertResponseOk($response)
    {
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(0, $content['code']);
        return $content;
    }

    public function assertResponseCode401($response)
    {
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertEquals(401, $content['code']);
    }
}
