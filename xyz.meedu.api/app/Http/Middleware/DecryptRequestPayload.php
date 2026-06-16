<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

// wire format: base64(IV[12] | ciphertext | AuthTag[16])
class DecryptRequestPayload
{
    private const IV_LENGTH  = 12;
    private const TAG_LENGTH = 16;
    private const CIPHER     = 'aes-256-gcm';

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
        if ($raw === false || strlen($raw) < self::IV_LENGTH + self::TAG_LENGTH) {
            return $this->badPayload();
        }

        $iv         = substr($raw, 0, self::IV_LENGTH);
        $tag        = substr($raw, -self::TAG_LENGTH);
        $ciphertext = substr($raw, self::IV_LENGTH, -self::TAG_LENGTH);

        $plain = openssl_decrypt($ciphertext, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv, $tag);
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
