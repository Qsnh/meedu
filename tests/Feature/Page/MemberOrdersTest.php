<?php

namespace Tests\Feature\Page;

use App\Services\Member\Models\User;
use Tests\TestCase;

class MemberOrdersTest extends TestCase
{

    public function test_member_orders_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.orders'));
    }

}
