<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V2\BaseController;
use App\Services\Course\Services\CourseService;
use App\Meedu\ServiceV2\Services\FullSearchServiceInterface;

class SearchController extends BaseController
{

    /**
     * @api {get} /api/v3/search [V3]全站搜索
     * @apiGroup 其它模块
     * @apiName SearchV3
     *
     * @apiParam {String} keywords 搜索关键字
     * @apiParam {String=vod:录播课,video:录播视频,live:直播课,book:电子书,topic:图文,paper:试卷,practice:练习,mock_paper:模拟卷} type 课程类型
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
    public function index(Request $request, FullSearchServiceInterface $fullSearchService)
    {
        $type = $request->input('type');
        $page = max(1, (int)$request->input('page'));
        $size = min(100, max(1, (int)$request->input('size', 10)));

        /**
         * @var CourseService $courseService
         */
        $keywords = $request->input('keywords', '');
        if (!$keywords) {
            return $this->error(__('请输入关键字'));
        }

        $data = $fullSearchService->search($keywords, $page, $size, $type);

        if ($data['data']) {
            foreach ($data['data'] as $key => $item) {
                $p = '';
                $shortDesc = $item['short_desc'];
                $desc = strip_tags($item['desc']);
                if (mb_stripos($shortDesc, $keywords) !== false) {
                    $p = $shortDesc;
                } elseif (($index = mb_stripos($desc, $keywords)) !== false) {
                    // 关键字左边的字符串截取
                    if ($index < 100) {
                        $leftStr = mb_substr($desc, 0, $index);
                    } else {
                        $leftStr = mb_substr($desc, $index - 100, 100);
                    }

                    // 关键字右边的字符串截取
                    $rightStr = mb_substr($desc, $index + mb_strlen($keywords), 100) . '...';

                    $p = $leftStr . $keywords . $rightStr;
                }
                $data['data'][$key]['p'] = $p;
            }
        }

        return $this->data($data);
    }
}
