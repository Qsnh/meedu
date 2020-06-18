<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Api\V2;

use App\Services\Course\Models\CourseCategory;

class CourseCategoriesTest extends Base
{
    public function test_courses()
    {
        factory(CourseCategory::class, 10)->create([
            'is_show' => CourseCategory::IS_SHOW_YES,
        ]);
        $response = $this->get('/api/v2/course_categories');
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(10, count($r['data']));
    }
}
