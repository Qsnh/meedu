<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Decrypts AES-GCM-256 encrypted request payloads sent by the frontend.
 * The frontend encrypts the body as: base64(IV[12] + ciphertext + AuthTag[16]).
 */
class DecryptRequestPayload
{
    public function handle(Request $request, Closure $next)
    {
        $payload = $request->input('payload');
        if (!is_string($payload) || $payload === '') {
            return $this->badPayload();
        }

        $key = config('meedu.system.aes_encrypt_key');
        if (strlen($key) !== 32) {
            return $this->badPayload();
        }
        $raw = base64_decode($payload, true);
        if ($raw === false || strlen($raw) < 28) {
            return $this->badPayload();
        }

        $iv         = substr($raw, 0, 12);
        $tag        = substr($raw, -16);
        $ciphertext = substr($raw, 12, -16);

        $plain = openssl_decrypt($ciphertext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
        if ($plain === false) {
            return $this->badPayload();
        }

        $data = json_decode($plain, true);
        if (!is_array($data)) {
            return $this->badPayload();
        }

        $request->replace($data);
        return $next($request);
    }

    private function badPayload()
    {
        return response()->json(['code' => 422, 'message' => '请求数据异常'], 422);
    }
}
