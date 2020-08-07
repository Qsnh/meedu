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

use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Interfaces\CourseServiceInterface;

class SearchController extends BaseController
{

    /**
     * @OA\Get(
     *     path="/search",
     *     summary="搜索",
     *     tags={"搜索"},
     *     @OA\Parameter(in="query",name="keywords",description="关键字",required=false,@OA\Schema(type="string")),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="data",type="array",description="数据列表",@OA\Items(ref="#/components/schemas/Course")),
     *             ),
     *         )
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CourseServiceInterface $courseService, Request $request)
    {
        /**
         * @var CourseService $courseService
         */
        $keywords = $request->input('keywords', '');
        if (!$keywords) {
            return $this->error('请输入关键字');
        }
        $courses = $courseService->titleSearch($keywords, 10);
        $courses = arr2_clear($courses, ApiV2Constant::MODEL_COURSE_FIELD);
        return $this->data([
            'data' => $courses,
            'keywords' => $keywords,
        ]);
    }
}
