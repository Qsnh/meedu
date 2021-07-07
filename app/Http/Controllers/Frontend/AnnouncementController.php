<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Frontend;

use App\Services\Other\Services\AnnouncementService;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;

class AnnouncementController extends FrontendController
{

    /**
     * @var AnnouncementService
     */
    protected $announcementService;

    public function __construct(AnnouncementServiceInterface $announcementService)
    {
        parent::__construct();

        $this->announcementService = $announcementService;
    }

    public function show($id)
    {
        $a = $this->announcementService->findOrFail($id);
        $this->announcementService->viewTimesInc($id);
        $title = $a['title'];
        return v('frontend.announcement.show', compact('a', 'title'));
    }
}
