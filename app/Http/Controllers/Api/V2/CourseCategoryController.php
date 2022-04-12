<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Constant\ApiV2Constant;
use App\Services\Course\Services\CourseCategoryService;
use App\Services\Course\Interfaces\CourseCategoryServiceInterface;

class CourseCategoryController extends BaseController
{
    /**
     * @var CourseCategoryService
     */
    protected $courseCategoryService;

    public function __construct(CourseCategoryServiceInterface $courseCategoryService)
    {
        $this->courseCategoryService = $courseCategoryService;
    }

    /**
     * @api {get} /api/v2/course_categories 录播课程分类
     * @apiGroup 录播课
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {Number} data.id 分类ID
     * @apiSuccess {String} data.name 分类名
     * @apiSuccess {Number} data.parent_id 分类父ID
     * @apiSuccess {Object[]} data.children 子类
     * @apiSuccess {Number} data.children.id 子分类ID
     * @apiSuccess {String} data.children.name 子分类名
     */
    public function all()
    {
        $categories = $this->courseCategoryService->all();
        $categories = arr2_clear($categories, ApiV2Constant::MODEL_COURSE_CATEGORY_FIELD);
        return $this->data($categories);
    }
}
