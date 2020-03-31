<?php


namespace Tests\Feature\BackendApi;


use App\Models\Administrator;

class UserTest extends Base
{

    public function test_user()
    {
        $admin = factory(Administrator::class)->create();
        $response = $this->user($admin)->get(self::API_V1_PREFIX . '/user');
        $data = $this->assertResponseSuccess($response);
        $this->assertEquals($admin->email, $data['data']['email']);
    }

}