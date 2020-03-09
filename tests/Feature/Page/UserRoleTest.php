<?php

namespace Tests\Feature\Page;

use App\Services\Member\Models\Role;
use Tests\TestCase;

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
