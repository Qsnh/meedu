<?php


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