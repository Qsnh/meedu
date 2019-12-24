<?php

namespace Tests\Feature\Page;

use App\Services\Member\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberPageTest extends TestCase
{

    public function test_member_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member'))
            ->see($user->nick_name);
    }

}
