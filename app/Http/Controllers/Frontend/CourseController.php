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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Services\CourseCommentService;

class CourseController extends FrontendController
{
    protected $courseService;
    protected $configService;
    protected $courseCommentService;
    protected $userService;
    protected $videoService;
    protected $orderService;

    public function __construct(
        CourseService $courseService,
        ConfigService $configService,
        CourseCommentService $courseCommentService,
        UserService $userService,
        VideoService $videoService,
        OrderService $orderService
    ) {
        $this->courseService = $courseService;
        $this->configService = $configService;
        $this->courseCommentService = $courseCommentService;
        $this->userService = $userService;
        $this->videoService = $videoService;
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $this->configService->getCourseListPageSize();
        [
            'total' => $total,
            'list' => $list
        ] = $this->courseService->simplePage($page, $pageSize);
        $courses = $this->paginator($list, $total, $page, $pageSize);
        [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
        ] = $this->configService->getSeoCourseListPage();

        return v('frontend.course.index', compact('courses', 'title', 'keywords', 'description'));
    }

    public function show($id, $slug)
    {
        $course = $this->courseService->find($id);
        $chapters = $this->courseService->chapters($course['id']);
        $videos = $this->videoService->courseVideos($course['id']);
        $comments = $this->courseCommentService->courseComments($course['id']);
        $commentUsers = $this->userService->getList(array_column($comments, 'user_id'), ['role']);
        $commentUsers = array_column($commentUsers, null, 'id');

        $title = sprintf('课程《%s》', $course['title']);
        $keywords = $course['seo_keywords'];
        $description = $course['seo_description'];

        return v('frontend.course.show', compact(
            'course',
            'title',
            'keywords',
            'description',
            'comments',
            'commentUsers',
            'videos',
            'chapters'
        ));
    }

    public function showBuyPage($id)
    {
        $course = $this->courseService->find($id);
        $title = sprintf('购买课程《%s》', $course['title']);

        return v('frontend.course.buy', compact('course', 'title'));
    }

    public function buyHandler($id)
    {
        $course = $this->courseService->find($id);
        $order = $this->orderService->createCourseOrder(Auth::id(), $course);

        flash(__('order successfully, please pay'), 'success');

        return redirect(route('order.show', $order['order_id']));
    }
}
