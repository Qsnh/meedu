<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Api\V2;

use App\Constant\ApiV2Constant;
use App\Services\Course\Services\CourseCategoryService;
use App\Services\Course\Interfaces\CourseCategoryServiceInterface;

/**
 * Class CourseCategoryController
 * @package App\Http\Controllers\Api\V2
 */
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
     * @OA\Get(
     *     path="/course_categories",
     *     summary="课程分类",
     *     tags={"课程"},
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="array",description="",@OA\Items(ref="#/components/schemas/CourseCategory")),
     *         )
     *     )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $categories = $this->courseCategoryService->all();
        $categories = arr2_clear($categories, ApiV2Constant::MODEL_COURSE_CATEGORY_FIELD);
        return $this->data($categories);
    }
}
