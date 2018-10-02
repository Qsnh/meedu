<?php

namespace Tests\Feature\Page;

use App\Models\Video;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoBuyTest extends TestCase
{

    public function test_visit_video_buy_page()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit(route('member.video.buy', $video))
            ->see($video->title)
            ->see($video->charge)
            ->see($user->credit1);
    }

    public function test_cant_buy_video_sufficient_credit1()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => mt_rand(1, 1000),
        ]);
        $user = factory(User::class)->create([
            'credit1' => 0,
        ]);
        $this->actingAs($user)
            ->visit(route('member.video.buy', $video))
            ->dontSee('立即购买');
    }

    public function test_buy_video_success()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'charge' => mt_rand(1, 1000),
        ]);
        $credit1 = mt_rand(1001, 100000);
        $user = factory(User::class)->create([
            'credit1' => $credit1,
        ]);
        $this->actingAs($user)
            ->visit(route('member.video.buy', $video))
            ->press('立即购买')
            ->seePageIs(route('video.show', [$video->course->id, $video->id, $video->slug]));
        $user = User::find($user->id);
        // 消息通知
        $this->assertTrue($user->unreadNotifications->count() > 0);
        // 余额减少
        $this->actingAs($user)
            ->visit(route('member'))
            ->see($credit1 - $video->charge);
        // 我购买的视频存在记录
        $this->actingAs($user)
            ->visit(route('member.course.videos'))
            ->see($video->title)
            ->see($video->charge);
        // 消费记录
        $this->actingAs($user)
            ->visit(route('member.orders'))
            ->see($video->title)
            ->see($video->charge);
        // 可以观看
        $response = $this->actingAs($user)
            ->visit(route('video.show', [$video->course->id, $video->id, $video->slug]));
        $this->assertRegExp("#{$video->url}#", $response->response->getContent());
    }

}
