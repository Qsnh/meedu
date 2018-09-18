<?php

namespace Tests\Feature\Page;

use App\Models\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRoleTest extends TestCase
{

    public function test_visit_user_role_page()
    {
        $response = $this->get(route('role.index'));
        $response->assertStatus(200);
        $response->assertSeeText('计划');
    }

    public function test_create_user_role()
    {
        $role = factory(Role::class)->create();
        $response = $this->get(route('role.index'));
        $response->assertStatus(200);
        $response->assertSeeText($role->name);
    }

}
