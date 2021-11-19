<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Constant\FrontendConstant;
use App\Services\Other\Services\NavService;
use App\Services\Other\Interfaces\NavServiceInterface;

class NavController extends BaseController
{

    /**
     * @api {get} /api/v2/navs 首页导航
     * @apiGroup 其它
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {String} data.name 导航名
     * @apiSuccess {String} data.url 链接
     * @apiSuccess {String} data.active_routes 子导航active[英文逗号连接]
     * @apiSuccess {Number} data.blank 新窗口打开[1:是,0否]
     * @apiSuccess {Object[]} data.children 子导航
     * @apiSuccess {String} data.children.name 子导航名
     * @apiSuccess {String} data.children.url 子导航链接
     * @apiSuccess {Number} data.children.blank 新窗口打开[1:是,0否]
     */
    public function all(Request $request)
    {
        $platform = $request->input('platform', FrontendConstant::NAV_PLATFORM_PC);

        /**
         * @var NavService $navService
         */
        $navService = app()->make(NavServiceInterface::class);

        $navs = $navService->all($platform);

        return $this->data($navs);
    }
}
