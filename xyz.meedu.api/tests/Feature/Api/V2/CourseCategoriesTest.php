<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V2;

use App\Services\Course\Models\CourseCategory;

class CourseCategoriesTest extends Base
{
    public function test_courses()
    {
        CourseCategory::factory()->count(10)->create(['is_show' => 1]);
        $response = $this->get('/api/v2/course_categories');
        $r = $this->assertResponseSuccess($response);
        $this->assertEquals(10, count($r['data']));
    }
}
