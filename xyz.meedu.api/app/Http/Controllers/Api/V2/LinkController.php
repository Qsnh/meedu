<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Meedu\Cache\Impl\LinkCache;

class LinkController extends BaseController
{

    /**
     * @api {get} /api/v2/links [V2]友情链接
     * @apiGroup 其它模块
     * @apiName OtherLinks
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {String} data.name 链接名
     * @apiSuccess {String} data.url 链接
     */
    public function all(LinkCache $linkCache)
    {
        return $this->data($linkCache->get());
    }
}
