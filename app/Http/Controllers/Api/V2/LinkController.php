<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Services\Other\Services\LinkService;
use App\Services\Other\Interfaces\LinkServiceInterface;

class LinkController extends BaseController
{

    /**
     * @api {get} /api/v2/links 友情链接
     * @apiGroup 其它
     * @apiName OtherLinks
     * @apiVersion v2.0.0
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object[]} data 数据
     * @apiSuccess {String} data.name 链接名
     * @apiSuccess {String} data.url 链接
     */
    public function all()
    {
        /**
         * @var LinkService $linkService
         */
        $linkService = app()->make(LinkServiceInterface::class);

        $links = $linkService->all();

        return $this->data($links);
    }
}
