<?php

namespace Tests\Feature\Api\V1;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\OriginalTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberTest extends OriginalTestCase
{

    public $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        Passport::actingAs($this->user);
    }

    public function test_member_profile()
    {
        Passport::actingAs($this->user);
        $this->json('GET', '/api/v1/member/profile')
            ->assertJsonFragment((new UserResource($this->user))->toArray(request()));
    }

    public function test_avatar_change()
    {
        $avatar = $this->user->avatar;
        $this->json('POST', '/api/v1/member/avatar', [
            'file' => UploadedFile::fake()->image('avatar.png'),
        ])
            ->assertStatus(200);
        $this->user = User::find($this->user->id);
        $this->assertTrue($this->user->avatar != $avatar);
    }

    public function test_password_change()
    {
        $oldPassword = '123456';
        $this->user->password = bcrypt($oldPassword);
        $this->user->save();

        $newPassword = str_random(8);
        $this->json('POST', '/api/v1/member/password/change', [
            'old_password' => $oldPassword,
            'new_password' => $newPassword,
            'new_password_confirmation' => $newPassword,
        ])->assertStatus(200);

        $this->user = User::find($this->user->id);
        $this->assertTrue(Hash::check($newPassword, $this->user->password));
    }

}
