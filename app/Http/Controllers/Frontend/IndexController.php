<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Meedu\Cache\Inc\Inc;
use App\Constant\FrontendConstant;
use App\Meedu\Cache\Inc\AdFromIncItem;
use App\Services\Other\Services\LinkService;
use App\Services\Base\Services\ConfigService;
use App\Services\Other\Services\AdFromService;
use App\Services\Other\Services\SliderService;
use App\Services\Course\Services\CourseService;
use App\Services\Other\Services\IndexBannerService;
use App\Services\Course\Services\CourseCategoryService;
use App\Services\Other\Interfaces\LinkServiceInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Other\Interfaces\AdFromServiceInterface;
use App\Services\Other\Interfaces\SliderServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Other\Interfaces\IndexBannerServiceInterface;
use App\Services\Course\Interfaces\CourseCategoryServiceInterface;

class IndexController extends FrontendController
{
    /**
     * @var LinkService
     */
    protected $linkService;
    /**
     * @var ConfigService
     */
    protected $configService;
    /**
     * @var SliderService
     */
    protected $sliderService;

    /**
     * @var CourseService
     */
    protected $courseService;

    /**
     * @var CourseCategoryService
     */
    protected $courseCategoryService;

    /**
     * @var IndexBannerService
     */
    protected $indexBannerService;

    /**
     * @var AdFromService
     */
    protected $adFromService;

    public function __construct(
        LinkServiceInterface $linkService,
        ConfigServiceInterface $configService,
        SliderServiceInterface $sliderService,
        CourseServiceInterface $courseService,
        CourseCategoryServiceInterface $courseCategoryService,
        IndexBannerServiceInterface $indexBannerService,
        AdFromServiceInterface $adFromService
    ) {
        $this->linkService = $linkService;
        $this->configService = $configService;
        $this->sliderService = $sliderService;
        $this->courseService = $courseService;
        $this->courseCategoryService = $courseCategoryService;
        $this->indexBannerService = $indexBannerService;
        $this->adFromService = $adFromService;
    }

    public function index()
    {
        $links = $this->linkService->all();

        [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description
        ] = $this->configService->getSeoIndexPage();

        if ($fromKey = request()->input('from_key')) {
            $adFrom = $this->adFromService->findFromKey($fromKey);
            $adFrom && Inc::record(new AdFromIncItem($adFrom));
        }

        // 幻灯片
        $sliders = $this->sliderService->all(is_h5() ? FrontendConstant::SLIDER_PLATFORM_H5 : FrontendConstant::SLIDER_PLATFORM_PC);

        // 课程
        [
            'total' => $total,
            'list' => $list
        ] = $this->courseService->simplePage(1, 16, 0);
        $courses = $this->paginator($list, $total, 1, 16, route('courses'));

        // 课程分类
        $categories = $this->courseCategoryService->all();

        // 首页banner
        $banners = $this->indexBannerService->all();
        foreach ($banners as $key => $banner) {
            $courseIds = explode(',', $banner['course_ids']);
            $banners[$key]['courses'] = [];
            $courseIds && $banners[$key]['courses'] = $this->courseService->getList($courseIds);
        }

        return v(
            'frontend.index.index',
            compact('title', 'keywords', 'description', 'links', 'sliders', 'courses', 'categories', 'banners')
        );
    }

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
