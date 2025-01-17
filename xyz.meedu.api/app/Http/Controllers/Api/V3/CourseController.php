<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V3;

use Illuminate\Http\Request;
use App\Bus\CourseAttachDownloadBus;
use App\Http\Controllers\Api\V2\BaseController;

class CourseController extends BaseController
{

    /**
     * @api {GET} /api/v3/course/{courseId}/attach/{id} [V3]录播课-附件-获取下载地址
     * @apiGroup 录播课模块
     * @apiName  GetCourseAttachDownloadUrl
     * @apiDescription v4.9.11新增
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.download_url 下载地址
     */
    public function attachDownloadUrl(CourseAttachDownloadBus $bus, $courseId, $id)
    {
        $url = $bus->generateDownloadSignature($this->id(), $id, $courseId);

        return $this->data(['download_url' => $url]);
    }

    public function attachDownloadDirect(Request $request, CourseAttachDownloadBus $bus)
    {
        $sign = $request->input('sign');
        if (!$sign) {
            return $this->error(__('参数错误'));
        }
        return $bus->download($sign);
    }

}
