<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests;

trait EncryptionTestTrait
{
    protected string $aesTestKey = 'test-aes-key-must-be-32-bytes!!!';

    protected function encryptRaw(string $json): string
    {
        $iv = random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt($json, 'aes-256-gcm', $this->aesTestKey, OPENSSL_RAW_DATA, $iv, $tag);
        return base64_encode($iv . $ciphertext . $tag);
    }

    protected function encryptBody(array $data): array
    {
        config(['meedu.system.aes_encrypt_key' => $this->aesTestKey]);
        return ['payload' => $this->encryptRaw(json_encode($data))];
    }
}
