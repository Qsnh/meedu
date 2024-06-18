<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Frontend;

use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class IndexController extends FrontendController
{
    public function index()
    {
        return __('API服务正在运行');
    }

    public function userProtocol()
    {
        $protocol = $this->configService->getMemberProtocol();
        return view('index.user_protocol', compact('protocol'));
    }

    public function userPrivateProtocol()
    {
        $protocol = $this->configService->getMemberPrivateProtocol();
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

    public function vipProtocol(ConfigServiceInterface  $configService)
    {
        $content = $configService->getVipProtocol();
        return view('index.vip_protocol', compact('content'));
    }
}
