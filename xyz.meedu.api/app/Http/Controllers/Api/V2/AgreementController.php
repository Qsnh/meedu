<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Meedu\ServiceV2\Services\AgreementServiceInterface;

class AgreementController extends BaseController
{
    /**
     * @api {post} /api/v2/agreements/agree [V2]协议-同意
     * @apiGroup 协议模块
     * @apiName AgreementAgree
     * @apiHeader Authorization Bearer+空格+token
     *
     * @apiSuccess {Number} code 0成功,非0失败
     * @apiSuccess {Object} data 数据
     * @apiSuccess {String} data.message 处理结果信息
     */
    public function agree(Request $request, AgreementServiceInterface $agreementService)
    {
        $userId = $this->id();
        $ip = $request->getClientIp();
        $userAgent = $request->userAgent();
        $platform = get_platform();

        // 获取所有必须同意的协议
        $requiredAgreements = $agreementService->getRequiredAgreements();

        if ($requiredAgreements) {
            foreach ($requiredAgreements as $agreement) {
                $agreementService->recordUserAgreement(
                    $userId,
                    $agreement['id'],
                    $ip,
                    $userAgent,
                    $platform
                );
            }
        }

        return $this->success();
    }
}
