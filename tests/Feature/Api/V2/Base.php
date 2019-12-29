<?php


namespace Tests\Feature\Api\V2;


use Tests\TestCase;

class Base extends TestCase
{

    protected function assertResponseError($response, $message = '')
    {
        $c = $response->response->getContent();
        dump($c);
        $c = json_decode($c, true);
        $this->assertNotEquals(0, $c['code']);
        $message && $this->assertEquals($message, $c['message']);
    }

}