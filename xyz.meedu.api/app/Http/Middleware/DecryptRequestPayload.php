<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DecryptRequestPayload
{
    public function handle(Request $request, Closure $next)
    {
        $payload = $request->input('payload');
        if (!is_string($payload) || $payload === '') {
            return response()->json(['code' => 422, 'message' => '请求数据异常'], 422);
        }

        $key = config('meedu.system.aes_encrypt_key');
        if (strlen($key) !== 32) {
            return response()->json(['code' => 422, 'message' => '请求数据异常'], 422);
        }
        $raw = base64_decode($payload, true);
        if ($raw === false || strlen($raw) < 28) {
            return response()->json(['code' => 422, 'message' => '请求数据异常'], 422);
        }

        $iv         = substr($raw, 0, 12);
        $tag        = substr($raw, -16);
        $ciphertext = substr($raw, 12, -16);

        $plain = openssl_decrypt($ciphertext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
        if ($plain === false) {
            return response()->json(['code' => 422, 'message' => '请求数据异常'], 422);
        }

        $data = json_decode($plain, true);
        if (!is_array($data)) {
            return response()->json(['code' => 422, 'message' => '请求数据异常'], 422);
        }

        $request->replace($data);
        return $next($request);
    }
}
