<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Api\V2;

use App\Services\Member\Models\Role;

class RoleTest extends Base
{
    public function test_roles()
    {
        factory(Role::class, 4)->create();
        $r = $this->getJson('api/v2/roles');
        $r = $this->assertResponseSuccess($r);
        $this->assertEquals(4, count($r['data']));
    }
}
