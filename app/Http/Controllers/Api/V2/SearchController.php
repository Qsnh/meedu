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
     * @apiVersion v2.0.0
     *
     * @apiParam {String} keywords 搜索关键字
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {Object} data.data 课程
     * @apiSuccess {Number} data.data.id 课程ID
     * @apiSuccess {String} data.data.title 课程名
     * @apiSuccess {String} data.data.thumb 封面
     * @apiSuccess {Number} data.data.charge 价格
     * @apiSuccess {String} data.data.short_description 简短介绍
     * @apiSuccess {String} data.data.render_desc 详细介绍
     * @apiSuccess {String} data.data.seo_keywords SEO关键字
     * @apiSuccess {String} data.data.seo_description SEO描述
     * @apiSuccess {String} data.data.published_at 上架时间
     * @apiSuccess {Number} data.data.is_rec 推荐[1:是,0否][已弃用]
     * @apiSuccess {Number} data.data.user_count 订阅人数
     * @apiSuccess {Number} data.data.videos_count 视频数
     * @apiSuccess {Object} data.data.category 分类
     * @apiSuccess {Number} data.data.category.id 分类ID
     * @apiSuccess {String} data.data.category.name 分类名
     */
    public function index(CourseServiceInterface $courseService, Request $request)
    {
        /**
         * @var CourseService $courseService
         */
        $keywords = $request->input('keywords', '');
        if (!$keywords) {
            return $this->error(__('请输入关键字'));
        }
        $courses = $courseService->titleSearch($keywords, 10);
        $courses = arr2_clear($courses, ApiV2Constant::MODEL_COURSE_FIELD);
        return $this->data([
            'data' => $courses,
            'keywords' => $keywords,
        ]);
    }
}
