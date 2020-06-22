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

use Tests\TestCase;
use App\Services\Other\Models\Announcement;

class AnnouncementTest extends TestCase
{
    public function test_member_orders_page()
    {
        $a = factory(Announcement::class)->create();
        $this->visit(route('announcement.show', $a))
            ->see($a->title);
    }
}
