<?php

namespace Tests\Unit\Middleware;

use Tests\CreatesApplication;
use Illuminate\Http\Request;
use App\Http\Middleware\DecryptRequestPayload;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class DecryptRequestPayloadTest extends BaseTestCase
{
    use CreatesApplication;

    private string $testKey = 'test-aes-key-must-be-32-bytes!!';

    private function encrypt(array $data): string
    {
        $iv = random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt(
            json_encode($data),
            'aes-256-gcm',
            $this->testKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        return base64_encode($iv . $ciphertext . $tag);
    }

    public function test_missing_payload_returns_422()
    {
        $middleware = new DecryptRequestPayload();
        $request = Request::create('/test', 'POST', []);

        $response = $middleware->handle($request, fn($req) => response()->json(['ok' => true]));

        $this->assertEquals(422, $response->getStatusCode());
        $body = json_decode($response->getContent(), true);
        $this->assertEquals('请求数据异常', $body['message']);
    }

    public function test_invalid_base64_returns_422()
    {
        $middleware = new DecryptRequestPayload();
        $request = Request::create('/test', 'POST', ['payload' => '!!!not-base64!!!']);

        $response = $middleware->handle($request, fn($req) => response()->json(['ok' => true]));

        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_wrong_key_returns_422()
    {
        $payload = $this->encrypt(['mobile' => '13800138000']);
        config(['meedu.system.aes_encrypt_key' => 'wrong-key-32-bytes-padding!!!!!']);

        $middleware = new DecryptRequestPayload();
        $request = Request::create('/test', 'POST', ['payload' => $payload]);

        $response = $middleware->handle($request, fn($req) => response()->json(['ok' => true]));

        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_valid_payload_merges_params_into_request()
    {
        $data = ['mobile' => '13800138000', 'password' => 'secret123'];
        $payload = $this->encrypt($data);
        config(['meedu.system.aes_encrypt_key' => $this->testKey]);

        $middleware = new DecryptRequestPayload();
        $request = Request::create('/test', 'POST', ['payload' => $payload]);

        $captured = null;
        $middleware->handle($request, function (Request $req) use (&$captured) {
            $captured = ['mobile' => $req->input('mobile'), 'password' => $req->input('password')];
            return response()->json(['ok' => true]);
        });

        $this->assertEquals('13800138000', $captured['mobile']);
        $this->assertEquals('secret123', $captured['password']);
    }

    public function test_too_short_raw_returns_422()
    {
        $payload = base64_encode(str_repeat('a', 10));
        config(['meedu.system.aes_encrypt_key' => $this->testKey]);

        $middleware = new DecryptRequestPayload();
        $request = Request::create('/test', 'POST', ['payload' => $payload]);

        $response = $middleware->handle($request, fn($req) => response()->json(['ok' => true]));

        $this->assertEquals(422, $response->getStatusCode());
    }
}
