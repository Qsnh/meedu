<?php

namespace Tests\Feature\Page;

use App\Models\Video;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberVideoTest extends TestCase
{

    public function test_member_video()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.course.videos'))
            ->see('暂无数据');
    }

    public function test_member_video_see_some_records()
    {
        $video = factory(Video::class)->create();
        $user = factory(User::class)->create();
        $charge = mt_rand(1, 100);
        $user->buyVideos()->attach($video->id, [
            'charge' => $charge,
            'created_at' => Carbon::now(),
        ]);
        $this->actingAs($user)
            ->visit(route('member.course.videos'))
            ->see($video->title)
            ->see($charge);
    }

}
