<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Meedu\ViewBlock\Render;
use App\Meedu\Cache\Impl\DecorationPageCache;

class DecorationPageController extends BaseController
{

    /**
     * @api {get} /api/v2/decorationPage/blocks [V2]装修-页面块
     * @apiGroup 装修模块
     * @apiName DecorationPageBlocks
     * @apiVersion v2.0.0
     *
     * @apiParam {String} page_name 页面标识（必填）
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
    public function blocks(
        Request $request,
        DecorationPageCache $decorationPageCache
    ) {
        $pageName = $request->input('page_name');
        if (!$pageName) {
            return $this->error('page_name参数不能为空');
        }

        $result = $decorationPageCache->getPageWithBlocks($pageName);

        if (!$result['page']) {
            return $this->data([]);
        }

        $blocks = Render::dataRender($result['blocks']);

        return $this->data($blocks);
    }
}
