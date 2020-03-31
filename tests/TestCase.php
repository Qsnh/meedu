<?php

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
