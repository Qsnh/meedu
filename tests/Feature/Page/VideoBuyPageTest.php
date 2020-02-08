<?php


namespace Tests\Feature\Page;


use App\Services\Course\Models\Video;
use App\Services\Member\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class VideoBuyPageTest extends TestCase
{

    public function test_member_orders_page()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $this->actingAs($user)
            ->visit(route('member.video.buy', [$video->id]))
            ->see($video->title);
    }

    /**
     * @expectedException \Laravel\BrowserKitTesting\HttpException
     */
    public function test_member_orders_page_with_no_published()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->addDays(1),
        ]);
        $this->actingAs($user)
            ->visitRoute('member.video.buy', [$video->id])
            ->seeStatusCode(404);
    }

    /**
     * @expectedException \Laravel\BrowserKitTesting\HttpException
     */
    public function test_member_orders_page_with_no_show()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_NO,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $this->actingAs($user)
            ->visitRoute('member.video.buy', [$video->id])
            ->seeStatusCode(404);
    }

}