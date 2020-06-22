<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Page;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Member\Models\UserVideo;

class VideoBuyPageTest extends TestCase
{
    public function test_member_orders_page()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'is_ban_sell' => 0,
        ]);
        $this->actingAs($user)
            ->visit(route('member.video.buy', [$video->id]))
            ->see($video->title);
    }

    public function test_member_orders_page_cannot_sold()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'is_ban_sell' => 1,
        ]);
        $this->actingAs($user)
            ->get(route('member.video.buy', [$video->id]));
        $this->assertTrue(session()->has('warning'));
        $this->assertEquals(__('this video cannot be sold'), session()->get('warning')->first());
    }

    public function test_member_orders_page_with_no_published()
    {
        $this->expectException(\Laravel\BrowserKitTesting\HttpException::class);

        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $this->actingAs($user)
            ->visitRoute('member.video.buy', [$video->id])
            ->seeStatusCode(404);
    }

    public function test_member_orders_page_with_no_show()
    {
        $this->expectException(\Laravel\BrowserKitTesting\HttpException::class);

        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_NO,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $this->actingAs($user)
            ->visitRoute('member.video.buy', [$video->id])
            ->seeStatusCode(404);
    }

    public function test_member_orders_page_with_repeat_buy()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        UserVideo::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'charge' => 1,
            'created_at' => Carbon::now(),
        ]);
        $this->actingAs($user)
            ->visit(route('member.video.buy', [$video->id]))
            ->seeStatusCode(200);
    }
}
