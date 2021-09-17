<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Services\Course\Services\CourseService;
use App\Services\Other\Proxies\SearchRecordService;
use App\Services\Other\Interfaces\SearchRecordServiceInterface;

class SearchController extends BaseController
{

    /**
     * @api {get} /api/v2/search 全站搜索
     * @apiGroup 搜索
     * @apiVersion v2.0.0
     *
     * @apiParam {String=vod=录播课,video=录播视频,live=直播课,book=电子书,topic=图文,paper=试卷,practice=练习} keywords 搜索关键字
     * @apiParam {String} type 课程类型
     * @apiParam {Number} size 每页数量
     * @apiParam {Number} page 页码
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data
     * @apiSuccess {Object[]} data.data
     * @apiSuccess {Number} data.data.id 资源ID
     * @apiSuccess {Number} data.data.resource_id 资源ID
     * @apiSuccess {String} data.data.resource_type 资源类型
     * @apiSuccess {String} data.data.title 标题
     * @apiSuccess {String} data.data.short_desc 简短介绍
     * @apiSuccess {String} data.data.desc 详细介绍
     * @apiSuccess {String} data.data.thumb 封面
     * @apiSuccess {Number} data.data.charge 价格
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        $size = abs((int)$request->input('size', 10));

        /**
         * @var CourseService $courseService
         */
        $keywords = $request->input('keywords', '');
        if (!$keywords) {
            return $this->error(__('请输入关键字'));
        }

        /**
         * @var SearchRecordService $searchService
         */
        $searchService = app()->make(SearchRecordServiceInterface::class);

        $data = $searchService->search($keywords, $size, $type);

        return $this->data([
            'data' => $data->items(),
            'total' => $data->total(),
        ]);
    }
}
