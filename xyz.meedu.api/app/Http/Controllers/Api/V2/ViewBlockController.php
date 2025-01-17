<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Meedu\ViewBlock\Render;
use App\Services\Other\Interfaces\ViewBlockServiceInterface;

class ViewBlockController extends BaseController
{

    /**
     * @api {get} /api/v2/viewBlock/page/blocks [V2]装修-页面块
     * @apiGroup 装修模块
     * @apiName ViewPageBlocks
     * @apiVersion v2.0.0
     *
     * @apiParam {String} platform 平台[APP,H5,PC,MINI]
     * @apiParam {String} page_name 页面标识
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {Number} data.id 记录ID
     * @apiSuccess {String} data.platform 平台
     * @apiSuccess {String} data.page_name 所属页面
     * @apiSuccess {String} data.sign 模块特征值
     * @apiSuccess {Number} data.sort 升序
     * @apiSuccess {String} data.config 配置(经过json_encode的字符串)
     * @apiSuccess {Object} data.config_render 配置(已转码)
     */
    public function pageBlocks(Request $request, ViewBlockServiceInterface $viewBlockService)
    {
        $page = $request->input('page_name');
        $platform = $request->input('platform');
        if (!$page || !$platform) {
            return $this->error(__('参数错误'));
        }

        $blocks = $viewBlockService->getPageBlocks($platform, $page);

        $blocks = Render::dataRender($blocks);

        return $this->data($blocks);
    }
}
