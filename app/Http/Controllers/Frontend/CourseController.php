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
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Services\CourseCommentService;
use App\Services\Course\Services\CourseCategoryService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;
use App\Services\Course\Interfaces\CourseCategoryServiceInterface;

class CourseController extends FrontendController
{
    /**
     * @var CourseService
     */
    protected $courseService;
    /**
     * @var ConfigService
     */
    protected $configService;
    /**
     * @var CourseCommentService
     */
    protected $courseCommentService;
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var VideoService
     */
    protected $videoService;
    /**
     * @var OrderService
     */
    protected $orderService;
    /**
     * @var CourseCategoryService
     */
    protected $courseCategoryService;

    public function __construct(
        CourseServiceInterface $courseService,
        ConfigServiceInterface $configService,
        CourseCommentServiceInterface $courseCommentService,
        UserServiceInterface $userService,
        VideoServiceInterface $videoService,
        OrderServiceInterface $orderService,
        CourseCategoryServiceInterface $courseCategoryService
    ) {
        $this->courseService = $courseService;
        $this->configService = $configService;
        $this->courseCommentService = $courseCommentService;
        $this->userService = $userService;
        $this->videoService = $videoService;
        $this->orderService = $orderService;
        $this->courseCategoryService = $courseCategoryService;
    }

    public function index(Request $request)
    {
        $categoryId = intval($request->input('category_id'));
        $page = $request->input('page', 1);
        $pageSize = $this->configService->getCourseListPageSize();
        [
            'total' => $total,
            'list' => $list
        ] = $this->courseService->simplePage($page, $pageSize, $categoryId);
        $courses = $this->paginator($list, $total, $page, $pageSize);
        $categoryId && $courses->appends(['category_id' => $categoryId]);
        [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
        ] = $this->configService->getSeoCourseListPage();
        $courseCategories = $this->courseCategoryService->all();

        return v('frontend.course.index', compact('courses', 'title', 'keywords', 'description', 'courseCategories', 'categoryId'));
    }

    public function show($id, $slug)
    {
        $course = $this->courseService->find($id);
        $chapters = $this->courseService->chapters($course['id']);
        $videos = $this->videoService->courseVideos($course['id']);
        $comments = $this->courseCommentService->courseComments($course['id']);
        $commentUsers = $this->userService->getList(array_column($comments, 'user_id'), ['role']);
        $commentUsers = array_column($commentUsers, null, 'id');

        $title = $course['title'];
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
        if ($this->userService->hasCourse(Auth::id(), $id)) {
            flash(__('You have already purchased this course'), 'success');
            return back();
        }
        $title = __('buy course', ['course' => $course['title']]);

        return v('frontend.course.buy', compact('course', 'title'));
    }

    public function buyHandler(Request $request, $id)
    {
        $promoCodeId = abs(intval($request->input('promo_code_id', 0)));
        $course = $this->courseService->find($id);
        $order = $this->orderService->createCourseOrder(Auth::id(), $course, $promoCodeId);

        if ($order['status'] == FrontendConstant::ORDER_PAID) {
            flash(__('success'), 'success');
            return redirect(route('course.show', [$course['id'], $course['slug']]));
        }

        flash(__('order successfully, please pay'), 'success');

        return redirect(route('order.show', $order['order_id']));
    }
}
