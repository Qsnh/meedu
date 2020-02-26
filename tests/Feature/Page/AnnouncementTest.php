<?php


namespace Tests\Feature\Page;


use App\Services\Other\Models\Announcement;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{

    public function test_member_orders_page()
    {
        $a = factory(Announcement::class)->create();
        $this->visit(route('announcement.show', $a))
            ->see($a->title);
    }

}