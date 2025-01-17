<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use App\Http\Requests\ApiV2\UploadImageRequest;

class UploadController extends BaseController
{
    /**
     * @api {post} /api/v2/upload/image [V2]上传-图片
     * @apiGroup 系统模块
     * @apiName UploadImage
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiParam {File} file 图片文件
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.path 本地路径
     * @apiSuccess {String} data.url URL
     * @apiSuccess {String} data.disk 存储磁盘
     * @apiSuccess {String} data.name 文件名
     */
    public function image(UploadImageRequest $request)
    {
        $data = $request->filldata();
        return $this->data($data);
    }
}
