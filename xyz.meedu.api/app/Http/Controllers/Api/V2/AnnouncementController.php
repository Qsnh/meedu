<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;

class AnnouncementController extends BaseController
{

    /**
     * @api {get} /api/v2/announcement/latest [V2]公告-最新一条
     * @apiGroup 其它模块
     * @apiName AnnouncementLatest
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.announcement 公告内容
     * @apiSuccess {String} data.title 标题
     * @apiSuccess {Number} data.view_times 浏览次数
     * @apiSuccess {String} data.created_at 时间
     */
    public function latest(AnnouncementServiceInterface $service)
    {
        $data = $service->latest();
        return $this->data($data);
    }

    /**
     * @api {get} /api/v2/announcement/{id} [V2]公告-详情
     * @apiGroup 其它模块
     * @apiName AnnouncementDetail
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.announcement 公告内容
     * @apiSuccess {String} data.title 标题
     * @apiSuccess {Number} data.view_times 浏览次数
     * @apiSuccess {String} data.created_at 时间
     */
    public function detail(AnnouncementServiceInterface $service, $id)
    {
        $ann = $service->findOrFail($id);
        return $this->data($ann);
    }

    /**
     * @api {get} /api/v2/announcements [V2]公告-列表
     * @apiGroup 其它模块
     * @apiName Announcements
     *
     * @apiParam {Number=1} [page] page
     * @apiParam {Number=10} [size] size
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {String} data.announcement 公告内容
     * @apiSuccess {String} data.title 标题
     * @apiSuccess {Number} data.view_times 浏览次数
     * @apiSuccess {String} data.created_at 创建时间
     */
    public function list(Request $request, AnnouncementServiceInterface $service)
    {
        $page = (int)$request->input('page', 1);
        $size = (int)$request->input('size', 10);

        $data = $service->paginate($page, $size);

        return $this->data($data);
    }
}
