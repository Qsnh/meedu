<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
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
