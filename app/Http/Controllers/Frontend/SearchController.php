<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SearchRequest;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Interfaces\CourseServiceInterface;

class SearchController extends Controller
{
    /**
     * @var CourseService
     */
    protected $courseService;

    public function __construct(CourseServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    public function searchHandler(SearchRequest $request)
    {
        ['keywords' => $keywords] = $request->filldata();
        $courses = [];
        $keywords && $courses = $this->courseService->titleSearch($keywords, 20);

        $title = '搜索';

        return v('frontend.search.index', compact('courses', 'title'));
    }
}
