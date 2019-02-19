<?php

namespace Tests\Feature\Api\V1;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\User;
use Laravel\Passport\Passport;
use Tests\OriginalTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VipTest extends OriginalTestCase
{

    public function test_vip_list()
    {
        $roles = factory(Role::class, 3)->create();
        $response = $this->json('GET', '/api/v1/roles');
        foreach ($roles as $role) {
            $response->assertJsonFragment((new RoleResource($role))->toArray(request()));
        }
    }

    public function test_buy_role()
    {
        $user = factory(User::class)->create([
            'credit1' => mt_rand(1000, 10000),
        ]);
        $role = factory(Role::class)->create(['charge' => mt_rand(1, 100)]);
        Passport::actingAs($user);
        $this->json('POST', '/api/v1/role/'.$role->id.'/buy')
            ->assertStatus(200);
    }

}
