<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V3;

use Tests\Feature\Api\V2\Base;
use App\Meedu\ServiceV2\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Meedu\ServiceV2\Models\UserDeleteJob;

class MemberTest extends Base
{
    public function test_user_destroy()
    {
        $user = User::factory()->create(['is_lock' => 0]);
        $response = $this->user($user)->postJson('/api/v3/member/destroy', []);
        $this->assertResponseSuccess($response);
    }

    public function test_user_destroy_repeat_submit()
    {
        $user = User::factory()->create(['is_lock' => 0]);
        $response = $this->user($user)->postJson('/api/v3/member/destroy', []);
        $this->assertResponseSuccess($response);

        $response = $this->user($user)->postJson('/api/v3/member/destroy', []);
        $this->assertResponseError($response, __('用户已申请注销'));
    }

    public function test_user_login_and_cancel_user_delete()
    {
        $user = User::factory()->create(['is_lock' => 0, 'password' => Hash::make('123123')]);
        $response = $this->user($user)->postJson('/api/v3/member/destroy', []);
        $this->assertResponseSuccess($response);

        $response = $this->user($user)->postJson('/api/v2/login/password', [
            'mobile' => $user['mobile'],
            'password' => '123123',
        ]);
        $this->assertResponseSuccess($response);

        $job = UserDeleteJob::query()->where('user_id', $user['id'])->exists();
        $this->assertFalse($job);
    }
}
