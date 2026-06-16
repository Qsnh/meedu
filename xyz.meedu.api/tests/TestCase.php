<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public $baseUrl = 'http://127.0.0.1:8000';

    protected string $aesTestKey = 'test-aes-key-must-be-32-bytes!!!';

    protected function encryptBody(array $data): array
    {
        config(['meedu.system.aes_encrypt_key' => $this->aesTestKey]);
        $iv = random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt(
            json_encode($data),
            'aes-256-gcm',
            $this->aesTestKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        return ['payload' => base64_encode($iv . $ciphertext . $tag)];
    }

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
