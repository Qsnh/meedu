<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V2;

use App\Constant\ApiV2Constant;
use App\Services\Course\Services\CourseService;
use App\Services\Other\Services\IndexBannerService;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Other\Interfaces\IndexBannerServiceInterface;

class IndexBannerController extends BaseController
{
    /**
     * @var IndexBannerService
     */
    protected $indexBannerService;

    /**
     * @var CourseService
     */
    protected $courseService;

    public function __construct(IndexBannerServiceInterface $indexBannerService, CourseServiceInterface $courseService)
    {
        $this->indexBannerService = $indexBannerService;
        $this->courseService = $courseService;
    }

    public function all()
    {
        $data = $this->indexBannerService->all();
        foreach ($data as $key => $banner) {
            $data[$key]['courses'] = [];
            $courseIds = explode(',', $banner['course_ids']);
            if ($courseIds) {
                $courses = $this->courseService->getList($courseIds);
                $courses = arr2_clear($courses, ApiV2Constant::MODEL_COURSE_FIELD);
                $data[$key]['courses'] = $courses;
            }
        }

        return $this->data($data);
    }
}
