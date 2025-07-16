<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Frontend;

use App\Constant\AgreementConstant;
use App\Meedu\Cache\Impl\ActiveAgreementCache;

class IndexController extends FrontendController
{
    public function index()
    {
        return __('API服务正在运行');
    }

    public function userProtocol()
    {
        $agreement = ActiveAgreementCache::getActiveAgreement(AgreementConstant::TYPE_USER_AGREEMENT);
        $protocol = $agreement['content'] ?? '';
        return view('index.user_protocol', compact('protocol'));
    }

    public function userPrivateProtocol()
    {
        $agreement = ActiveAgreementCache::getActiveAgreement(AgreementConstant::TYPE_PRIVACY_POLICY);
        $protocol = $agreement['content'] ?? '';
        return view('index.user_private_protocol', compact('protocol'));
    }

    public function aboutus()
    {
        $content = $this->configService->getAboutus();
        return view('index.aboutus', compact('content'));
    }

    public function faceVerifySuccess()
    {
        return view('index.face_verify_success');
    }

    public function vipProtocol()
    {
        $agreement = ActiveAgreementCache::getActiveAgreement(AgreementConstant::TYPE_VIP_SERVICE_AGREEMENT);
        $content = $agreement['content'] ?? '';
        return view('index.vip_protocol', compact('content'));
    }

    public function paidContentPurchaseProtocol()
    {
        $agreement = ActiveAgreementCache::getActiveAgreement(AgreementConstant::TYPE_PAID_CONTENT_PURCHASE_AGREEMENT);
        $content = $agreement['content'] ?? '';
        return view('index.paid_content_purchase_protocol', compact('content'));
    }
}
