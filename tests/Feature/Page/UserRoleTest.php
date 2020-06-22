<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Page;

use Tests\TestCase;
use App\Services\Member\Models\Role;

class UserRoleTest extends TestCase
{
    public function test_visit_user_role_page()
    {
        $response = $this->get(route('role.index'));
        $response->assertResponseStatus(200);
        $response->see('开通会员');
    }

    public function test_create_user_role()
    {
        $role = factory(Role::class)->create();
        $response = $this->get(route('role.index'));
        $response->assertResponseStatus(200);
        $response->see($role->name)
            ->see($role->charge);
    }
}
