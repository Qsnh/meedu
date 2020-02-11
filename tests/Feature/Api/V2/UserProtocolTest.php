<?php


namespace Tests\Feature\Api\V2;


class UserProtocolTest extends Base
{

    public function test_run()
    {
        $protocol = '哈哈';
        config(['meedu.member.protocol' => $protocol]);
        $response = $this->getJson('/api/v2/other/userProtocol');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals($protocol, $response['data']);
    }

}