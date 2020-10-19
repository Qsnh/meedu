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

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Businesses\BusinessState;
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
    /**
     * @var BusinessState
     */
    protected $businessState;

    public function __construct(
        CourseServiceInterface $courseService,
        ConfigServiceInterface $configService,
        CourseCommentServiceInterface $courseCommentService,
        UserServiceInterface $userService,
        VideoServiceInterface $videoService,
        OrderServiceInterface $orderService,
        CourseCategoryServiceInterface $courseCategoryService,
        BusinessState $businessState
    ) {
        $this->courseService = $courseService;
        $this->configService = $configService;
        $this->courseCommentService = $courseCommentService;
        $this->userService = $userService;
        $this->videoService = $videoService;
        $this->orderService = $orderService;
        $this->courseCategoryService = $courseCategoryService;
        $this->businessState = $businessState;
    }

    public function index(Request $request)
    {
        $categoryId = (int)$request->input('category_id');
        $scene = $request->input('scene', '');

        $page = $request->input('page', 1);
        $pageSize = $this->configService->getCourseListPageSize();

        [
            'total' => $total,
            'list' => $list
        ] = $this->courseService->simplePage($page, $pageSize, $categoryId, $scene);
        $courses = $this->paginator($list, $total, $page, $pageSize);

        // 分页参数注入
        $courses->appends([
            'category_id' => $categoryId,
            'scene' => $request->input('scene', ''),
        ]);

        // SEO信息
        [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
        ] = $this->configService->getSeoCourseListPage();

        // 课程分类
        $courseCategories = $this->courseCategoryService->all();

        return v('frontend.course.index', compact(
            'courses',
            'title',
            'keywords',
            'description',
            'courseCategories',
            'categoryId',
            'scene'
        ));
    }

    public function show(Request $request, $id, $slug)
    {
        $scene = $request->input('scene', '');

        $course = $this->courseService->find($id);
        $chapters = $this->courseService->chapters($course['id']);
        $videos = $this->videoService->courseVideos($course['id']);

        // 课程评论
        $comments = $this->courseCommentService->courseComments($course['id']);
        $commentUsers = $this->userService->getList(array_column($comments, 'user_id'), ['role']);
        $commentUsers = array_column($commentUsers, null, 'id');
        $category = $this->courseCategoryService->findOrFail($course['category_id']);

        $title = $course['title'];
        $keywords = $course['seo_keywords'];
        $description = $course['seo_description'];

        // 课程附件
        $attach = $this->courseService->getCourseAttach($course['id']);

        // 是否购买
        $isBuy = false;
        // 喜欢课程
        $isLikeCourse = false;
        // 该课程的第一个视频
        $firstVideo = [];
        // 课程视频观看进度
        $videoWatchedProgress = [];
        // 课程评论
        $canComment = $this->businessState->courseCanComment($this->user(), $course);

        // 已登录用户的一些判断
        if (Auth::check()) {
            // 是否购买
            $isBuy = $this->businessState->isBuyCourse($this->id(), $course['id']);
            // 是否收藏当前课程
            $isLikeCourse = $this->userService->likeCourseStatus($this->id(), $course['id']);
            // 课程视频观看进度
            $userVideoWatchRecords = $this->userService->getUserVideoWatchRecords($this->id(), $course['id']);
            $videoWatchedProgress = array_column($userVideoWatchRecords, null, 'video_id');
            // 最近一条观看记录
            $latestWatchRecord = $this->userService->getLatestRecord($this->id(), $course['id']);
            $latestWatchRecord && $firstVideo = $this->videoService->find($latestWatchRecord['video_id']);
        }

        if (!$firstVideo) {
            $firstChapter = Arr::first($chapters);
            if ($firstChapter && ($videos[$firstChapter['id']] ?? [])) {
                $firstVideo = $videos[$firstChapter['id']][0];
            } else {
                Arr::first($videos) && $firstVideo = $videos[0][0];
            }
        }

        return v('frontend.course.show', compact(
            'course',
            'title',
            'keywords',
            'description',
            'comments',
            'commentUsers',
            'videos',
            'chapters',
            'isBuy',
            'category',
            'isLikeCourse',
            'firstVideo',
            'scene',
            'videoWatchedProgress',
            'attach',
            'canComment'
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
        $goods = [
            'id' => $course['id'],
            'title' => $course['title'],
            'thumb' => $course['thumb'],
            'charge' => $course['charge'],
            'label' => '整套课程',
        ];
        $total = $course['charge'];
        $scene = get_payment_scene();
        $payments = get_payments($scene);

        return v('frontend.order.create', compact('goods', 'title', 'total', 'scene', 'payments'));
    }

    public function buyHandler(Request $request)
    {
        $id = $request->input('goods_id');
        $promoCodeId = abs((int)$request->input('promo_code_id'));
        $course = $this->courseService->find($id);
        if ($course['charge'] <= 0) {
            flash(__('course cant buy'));
            return back();
        }
        $order = $this->orderService->createCourseOrder(Auth::id(), $course, $promoCodeId);

        if ($order['status'] === FrontendConstant::ORDER_PAID) {
            flash(__('success'), 'success');
            return redirect(route('course.show', [$course['id'], $course['slug']]));
        }

        $paymentScene = $request->input('payment_scene');
        $payment = $request->input('payment_sign');

        return redirect(route('order.pay', ['scene' => $paymentScene, 'payment' => $payment, 'order_id' => $order['order_id']]));
    }

    public function attachDownload($id)
    {
        $courseAttach = $this->courseService->getAttach($id);
        if (!$this->businessState->isBuyCourse(Auth::id(), $courseAttach['course_id'])) {
            abort(403, __('please buy course'));
        }
        $this->courseService->courseAttachDownloadTimesInc($courseAttach['id']);
        return response()->download(storage_path('app/attach/' . $courseAttach['path']));
    }
}
