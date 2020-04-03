<?php


namespace Tests\Feature\BackendApi;


use Tests\TestCase;

class Base extends TestCase
{

    public const API_V1_PREFIX = '/backend/api/v1';

    protected function user($user)
    {
        return $this->actingAs($user, 'administrator');
    }

    public function assertResponseError($response, $message = '')
    {
        $c = $response->response->getContent();
        $c = json_decode($c, true);
        $this->assertNotEquals(0, $c['status']);
        $message && $this->assertEquals($message, $c['message']);
    }

    public function assertResponseSuccess($response)
    {
        $c = $response->response->getContent();
        $c = json_decode($c, true);
        $this->assertEquals(0, $c['status']);
        return $c;
    }

}