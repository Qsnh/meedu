<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Bus;

use Carbon\Carbon;
use Tests\TestCase;
use App\Businesses\BusinessState;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;

class VipFreeCourseTest extends TestCase
{
    public function test_vip_user_can_see_vip_free_course()
    {
        // 创建VIP角色
        $role = Role::factory()->create();
        
        // 创建VIP用户
        $user = User::factory()->create([
            'role_id' => $role->id,
            'role_expired_at' => Carbon::now()->addDays(30)
        ]);
        
        // 创建VIP免费课程
        $course = Course::factory()->create([
            'is_vip_free' => Course::IS_VIP_FREE_YES,
            'is_free' => Course::IS_FREE_NO,
            'charge' => 100
        ]);
        
        $video = Video::factory()->create(['course_id' => $course->id]);
        
        $businessState = new BusinessState();
        $canSee = $businessState->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray());
        
        $this->assertTrue($canSee);
    }

    public function test_non_vip_user_cannot_see_vip_free_course()
    {
        // 创建普通用户
        $user = User::factory()->create(['role_id' => 0]);
        
        // 创建VIP免费课程
        $course = Course::factory()->create([
            'is_vip_free' => Course::IS_VIP_FREE_YES,
            'is_free' => Course::IS_FREE_NO,
            'charge' => 100
        ]);
        
        $video = Video::factory()->create(['course_id' => $course->id]);
        
        $businessState = new BusinessState();
        $canSee = $businessState->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray());
        
        $this->assertFalse($canSee);
    }

    public function test_expired_vip_user_cannot_see_vip_free_course()
    {
        // 创建VIP角色
        $role = Role::factory()->create();
        
        // 创建过期VIP用户
        $user = User::factory()->create([
            'role_id' => $role->id,
            'role_expired_at' => Carbon::now()->subDays(1) // 昨天过期
        ]);
        
        // 创建VIP免费课程
        $course = Course::factory()->create([
            'is_vip_free' => Course::IS_VIP_FREE_YES,
            'is_free' => Course::IS_FREE_NO,
            'charge' => 100
        ]);
        
        $video = Video::factory()->create(['course_id' => $course->id]);
        
        $businessState = new BusinessState();
        $canSee = $businessState->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray());
        
        $this->assertFalse($canSee);
    }

    public function test_vip_user_can_buy_vip_free_course()
    {
        // 创建VIP角色
        $role = Role::factory()->create();
        
        // 创建VIP用户
        $user = User::factory()->create([
            'role_id' => $role->id,
            'role_expired_at' => Carbon::now()->addDays(30)
        ]);
        
        // 创建VIP免费课程
        $course = Course::factory()->create([
            'is_vip_free' => Course::IS_VIP_FREE_YES,
            'is_free' => Course::IS_FREE_NO,
            'charge' => 100
        ]);
        
        $businessState = new BusinessState();
        $canBuy = $businessState->isBuyCourse($user->id, $course->id);
        
        $this->assertTrue($canBuy);
    }
}
