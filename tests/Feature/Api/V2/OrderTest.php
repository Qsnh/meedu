<?php


namespace Tests\Feature\Api\V2;


use App\Services\Course\Models\Course;
use App\Services\Course\Models\Video;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use Carbon\Carbon;

class OrderTest extends Base
{

    public function test_createCourseOrder()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/course', [
            'course_id' => $course->id,
            'promo_code_id' => 0,
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_createRoleOrder()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create([
            'charge' => 100,
            'is_show' => Course::SHOW_YES,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/role', [
            'role_id' => $role->id,
            'promo_code_id' => 0,
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_createVideoOrder()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/video', [
            'video_id' => $video->id,
            'promo_code_id' => 0,
        ]);
        $this->assertResponseSuccess($response);
    }

}