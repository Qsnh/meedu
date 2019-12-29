<?php


namespace Tests\Feature\Api\V2;


use App\Constant\ApiV2Constant;
use App\Services\Member\Models\User;

class LoginPasswordTest extends Base
{

    public function test_with_correct_password()
    {
        $user = factory(User::class)->create([
            'mobile' => '13890900909',
        ]);
        $response = $this->postJson('/api/v2/login/password', [
            'mobile' => $user->mobile,
            'password' => '123456',
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_with_error_password()
    {
        $user = factory(User::class)->create([
            'mobile' => '13890900909',
        ]);
        $response = $this->postJson('/api/v2/login/password', [
            'mobile' => $user->mobile,
            'password' => 'asd12312',
        ]);
        $this->assertResponseError($response, __(ApiV2Constant::MOBILE_OR_PASSWORD_ERROR));
    }

}