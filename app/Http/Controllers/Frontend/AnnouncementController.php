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

use App\Http\Controllers\Controller;
use App\Services\Other\Services\AnnouncementService;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;

class AnnouncementController extends Controller
{

    /**
     * @var AnnouncementService
     */
    protected $announcementService;

    public function __construct(AnnouncementServiceInterface $announcementService)
    {
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
