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
use App\Businesses\BusinessState;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\Services\ConfigService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Services\OrderService;
use App\Services\Course\Services\VideoService;
use App\Services\Course\Services\CourseService;
use App\Services\Course\Services\VideoCommentService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Order\Interfaces\OrderServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;

class VideoController extends FrontendController
{
    /**
     * @var VideoService
     */
    protected $videoService;
    /**
     * @var ConfigService
     */
    protected $configService;
    /**
     * @var VideoCommentService
     */
    protected $videoCommentService;
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var CourseService
     */
    protected $courseService;
    /**
     * @var BusinessState
     */
    protected $businessState;
    /**
     * @var OrderService
     */
    protected $orderService;

    public function __construct(
        VideoServiceInterface $videoService,
        ConfigServiceInterface $configService,
        VideoCommentServiceInterface $videoCommentService,
        UserServiceInterface $userService,
        CourseServiceInterface $courseService,
        BusinessState $businessState,
        OrderServiceInterface $orderService
    ) {
        $this->videoService = $videoService;
        $this->configService = $configService;
        $this->videoCommentService = $videoCommentService;
        $this->userService = $userService;
        $this->courseService = $courseService;
        $this->businessState = $businessState;
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $this->configService->getVideoListPageSize();
        [
            'list' => $list,
            'total' => $total
        ] = $this->videoService->simplePage($page, $pageSize);
        $videos = $this->paginator($list, $total, $page, $pageSize);
        $title = __('all videos');

        return v('frontend.video.index', compact('videos', 'title'));
    }

    public function show($courseId, $id, $slug)
    {
        $video = $this->videoService->find($id);
        $comments = $this->videoCommentService->videoComments($video['id']);
        $commentUsers = $this->userService->getList(array_column($comments, 'user_id'));
        $commentUsers = array_column($commentUsers, null, 'id');
        $chapters = $this->courseService->chapters($video['course_id']);
        $videos = $this->videoService->courseVideos($video['course_id']);
        $canSeeVideo = false;
        if (Auth::check()) {
            $canSeeVideo = $this->businessState->canSeeVideo($this->user(), $video['course'], $video);
        }

        $title = $video['title'];
        $keywords = $video['seo_keywords'];
        $description = $video['seo_description'];

        return v('frontend.video.show', compact(
            'video',
            'title',
            'keywords',
            'description',
            'comments',
            'commentUsers',
            'videos',
            'chapters',
            'canSeeVideo'
        ));
    }

    public function showBuyPage($id)
    {
        $video = $this->videoService->find($id);
        $title = __('buy video', ['video' => $video['title']]);

        return v('frontend.video.buy', compact('video', compact('title')));
    }

    public function buyHandler($id)
    {
        $video = $this->videoService->find($id);
        $order = $this->orderService->createVideoOrder(Auth::id(), $video);

        flash(__('order successfully, please pay'), 'success');

        return redirect(route('order.show', $order['order_id']));
    }
}
