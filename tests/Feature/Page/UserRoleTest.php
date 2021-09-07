<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
    }

    public function test_create_user_role()
    {
        $role = Role::factory()->create();
        $response = $this->get(route('role.index'));
        $response->assertResponseStatus(200);
        $response->see($role->name)
            ->see($role->charge);
    }
}
