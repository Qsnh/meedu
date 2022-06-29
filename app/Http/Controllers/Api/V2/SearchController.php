<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Constant\ApiV2Constant;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Interfaces\CourseServiceInterface;

class SearchController extends BaseController
{

    /**
     * @api {get} /api/v2/search 录播课程搜索
     * @apiGroup 搜索
     * @apiName SearchV2
     * @apiVersion v2.0.0
     *
     * @apiParam {String} keywords 搜索关键字
     * @apiParam {Number} size 每页数量
     * @apiParam {Number} page 页码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Number} data.id 课程ID
     * @apiSuccess {String} data.title 课程名
     * @apiSuccess {String} data.thumb 封面
     * @apiSuccess {Number} data.charge 价格
     * @apiSuccess {String} data.short_description 简短介绍
     * @apiSuccess {String} data.render_desc 详细介绍
     * @apiSuccess {String} data.seo_keywords SEO关键字
     * @apiSuccess {String} data.seo_description SEO描述
     * @apiSuccess {String} data.published_at 上架时间
     * @apiSuccess {Number} data.is_rec 推荐[1:是,0否][已弃用]
     * @apiSuccess {Number} data.user_count 订阅人数
     * @apiSuccess {Number} data.videos_count 视频数
     * @apiSuccess {Object} data.category 分类
     * @apiSuccess {Number} data.category.id 分类ID
     * @apiSuccess {String} data.category.name 分类名
     */
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        if (!$keywords) {
            return $this->error(__('请输入关键字'));
        }

        /**
         * @var CourseService $courseService
         */
        $courseService = app()->make(CourseServiceInterface::class);

        $courses = $courseService->titleSearch($keywords, 10);
        $courses = arr2_clear($courses, ApiV2Constant::MODEL_COURSE_FIELD);
        return $this->data([
            'data' => $courses,
            'keywords' => $keywords,
        ]);
    }
}
