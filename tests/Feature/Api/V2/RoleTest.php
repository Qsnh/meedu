<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V2;

use App\Services\Member\Models\Role;

class RoleTest extends Base
{
    public function test_roles()
    {
        Role::factory()->count(4)->create();
        $r = $this->getJson('api/v2/roles');
        $r = $this->assertResponseSuccess($r);
        $this->assertEquals(4, count($r['data']));
    }
}
