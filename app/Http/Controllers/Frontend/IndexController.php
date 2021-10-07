<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Frontend;

class IndexController extends FrontendController
{
    public function userProtocol()
    {
        $protocol = $this->configService->getMemberProtocol();
        return v('frontend.index.user_protocol', compact('protocol'));
    }

    public function userPrivateProtocol()
    {
        $protocol = $this->configService->getMemberPrivateProtocol();
        return v('frontend.index.user_private_protocol', compact('protocol'));
    }

    public function aboutus()
    {
        $aboutus = $this->configService->getAboutus();
        return v('frontend.index.aboutus', compact('aboutus'));
    }
}
