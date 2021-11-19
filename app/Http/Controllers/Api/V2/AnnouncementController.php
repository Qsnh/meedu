<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Services\Other\Services\AnnouncementService;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;

class AnnouncementController extends BaseController
{

    /**
     * @api {get} /api/v2/announcement/latest 最新公告
     * @apiGroup 其它
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.announcement 公告内容
     * @apiSuccess {String} data.title 标题
     * @apiSuccess {Number} data.view_times 浏览次数
     * @apiSuccess {String} data.created_at 时间
     */
    public function latest()
    {
        /**
         * @var AnnouncementService $annService
         */
        $annService = app()->make(AnnouncementServiceInterface::class);

        $ann = $annService->latest();

        return $this->data($ann);
    }

    /**
     * @api {get} /api/v2/announcement/{id} 公告详情
     * @apiGroup 其它
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.announcement 公告内容
     * @apiSuccess {String} data.title 标题
     * @apiSuccess {Number} data.view_times 浏览次数
     * @apiSuccess {String} data.created_at 时间
     */
    public function detail($id)
    {
        /**
         * @var AnnouncementService $annService
         */
        $annService = app()->make(AnnouncementServiceInterface::class);

        $ann = $annService->findOrFail($id);

        return $this->data($ann);
    }

    /**
     * @api {get} /api/v2/announcements 公告列表
     * @apiGroup 其它
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {String} data.announcement 公告内容
     * @apiSuccess {String} data.title 标题
     * @apiSuccess {Number} data.view_times 浏览次数
     * @apiSuccess {String} data.created_at 时间
     */
    public function list(Request $request)
    {
        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 10);

        /**
         * @var AnnouncementService $annService
         */
        $annService = app()->make(AnnouncementServiceInterface::class);

        $data = $annService->paginate($page, $size);

        return $this->data($data);
    }
}
