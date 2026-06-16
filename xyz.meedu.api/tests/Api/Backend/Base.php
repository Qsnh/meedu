<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Api\Backend;

use Tests\TestCase;

class Base extends TestCase
{
    public const API_V1_PREFIX = '/backend/api/v1';

    protected string $aesTestKey = 'test-aes-key-must-be-32-bytes!!!';

    protected function encryptBody(array $data): array
    {
        config(['meedu.system.aes_encrypt_key' => $this->aesTestKey]);
        $iv = random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt(json_encode($data), 'aes-256-gcm', $this->aesTestKey, OPENSSL_RAW_DATA, $iv, $tag);
        return ['payload' => base64_encode($iv . $ciphertext . $tag)];
    }

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
