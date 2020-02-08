<?php


namespace Tests\Feature\Page;

use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use Tests\TestCase;

class RoleBuyTest extends TestCase
{

    public function test_member_orders_page()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create([
            'is_show' => Role::IS_SHOW_YES,
        ]);
        $this->actingAs($user)
            ->visit(route('member.role.buy', [$role->id]))
            ->see($role->name);
    }

    /**
     * @expectedException \Laravel\BrowserKitTesting\HttpException
     */
    public function test_member_orders_page_with_no_show()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create([
            'is_show' => Role::IS_SHOW_NO,
        ]);
        $this->actingAs($user)
            ->visit(route('member.role.buy', [$role->id]))
            ->see($role->name);
    }

}