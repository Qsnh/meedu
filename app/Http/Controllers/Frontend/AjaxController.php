<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Bus\AuthBus;
use App\Bus\VideoBus;
use Illuminate\Http\Request;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use App\Http\Controllers\BaseController;
use App\Services\Member\Services\UserService;
use App\Services\Course\Services\VideoService;
use App\Http\Requests\ApiV2\MobileLoginRequest;
use App\Services\Course\Services\CourseService;
use App\Services\Order\Services\PromoCodeService;
use App\Http\Requests\Frontend\LoginPasswordRequest;
use App\Http\Requests\Frontend\PasswordResetRequest;
use App\Services\Course\Services\VideoCommentService;
use App\Services\Course\Services\CourseCommentService;
use App\Http\Requests\Frontend\RegisterPasswordRequest;
use App\Http\Requests\Frontend\Member\MobileBindRequest;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;
use App\Http\Requests\Frontend\Member\AvatarChangeRequest;
use App\Http\Requests\Frontend\Member\ReadAMessageRequest;
use App\Services\Course\Interfaces\CourseServiceInterface;
use App\Services\Member\Services\UserInviteBalanceService;
use App\Http\Requests\Frontend\Member\NicknameChangeRequest;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;
use App\Http\Requests\Frontend\CourseOrVideoCommentCreateRequest;
use App\Http\Requests\Frontend\Member\MemberPasswordResetRequest;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;
use App\Http\Requests\Frontend\Member\InviteBalanceWithdrawRequest;
use App\Services\Member\Interfaces\UserInviteBalanceServiceInterface;

class AjaxController extends BaseController
{
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var CourseService
     */
    protected $courseService;
    /**
     * @var VideoService
     */
    protected $videoService;

    protected $businessState;

    public function __construct(
        UserServiceInterface $userService,
        VideoServiceInterface $videoService,
        CourseServiceInterface $courseService,
        BusinessState $businessState
    ) {
        parent::__construct();

        $this->userService = $userService;
        $this->videoService = $videoService;
        $this->courseService = $courseService;
        $this->businessState = $businessState;
    }

    public function courseCommentHandler(
        CourseOrVideoCommentCreateRequest $request,
        CourseCommentServiceInterface $courseCommentService,
        $courseId
    ) {
        /**
         * @var CourseCommentService $courseCommentService
         */

        $course = $this->courseService->find($courseId);

        $user = $this->userService->find($this->id(), ['role']);

        if ($this->businessState->courseCanComment($user, $course) === false) {
            return $this->error(__('无权限'));
        }

        ['content' => $content] = $request->filldata();

        $comment = $courseCommentService->create($course['id'], $content);


        return $this->data([
            'content' => $comment['render_content'],
            'created_at' => Carbon::parse($comment['created_at'])->diffForHumans(),
            'user' => [
                'nick_name' => $user['nick_name'],
                'avatar' => $user['avatar'],
                'role' => $user['role'] ? $user['role']['name'] : __('免费会员'),
            ],
        ]);
    }

    public function videoCommentHandler(
        CourseOrVideoCommentCreateRequest $request,
        VideoCommentServiceInterface $videoCommentService,
        $videoId
    ) {
        /**
         * @var VideoCommentService $videoCommentService
         */

        $video = $this->videoService->find($videoId);

        $user = $this->userService->find($this->id(), ['role']);

        if ($this->businessState->videoCanComment($this->user(), $video) === false) {
            return $this->error(__('无权限'));
        }

        ['content' => $content] = $request->filldata();

        $comment = $videoCommentService->create($video['id'], $content);

        return $this->data([
            'content' => $comment['render_content'],
            'created_at' => Carbon::parse($comment['created_at'])->diffForHumans(),
            'user' => [
                'nick_name' => $user['nick_name'],
                'avatar' => $user['avatar'],
                'role' => $user['role'] ? $user['role']['name'] : __('免费会员'),
            ],
        ]);
    }

    public function promoCodeCheck(Request $request, PromoCodeServiceInterface $promoCodeService)
    {
        /**
         * @var PromoCodeService $promoCodeService
         */

        $promoCode = $request->input('promo_code');
        if (!$promoCode) {
            return $this->error(__('错误'));
        }
        $code = $promoCodeService->findCode($promoCode);
        if (!$code) {
            return $this->error(__('该码不存在'));
        }
        if ($code['expired_at'] && Carbon::now()->gt($code['expired_at'])) {
            return $this->error(__('该码已过期'));
        }
        if (!$this->businessState->promoCodeCanUse($code)) {
            return $this->error(__('该码无法使用'));
        }
        return $this->data([
            'id' => $code['id'],
            'discount' => $code['invited_user_reward'],
        ]);
    }

    public function passwordLogin(LoginPasswordRequest $request, AuthBus $bus)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();
        $user = $this->userService->passwordLogin($mobile, $password);
        if (!$user) {
            return $this->error(__('手机号或密码错误'));
        }
        if ((int)$user['is_lock'] === 1) {
            return $this->error(__('账号已被锁定'));
        }

        $bus->webLogin(
            $user['id'],
            $request->has('remember'),
            is_h5() ? FrontendConstant::LOGIN_PLATFORM_H5 : FrontendConstant::LOGIN_PLATFORM_PC
        );

        return $this->data(['redirect_url' => $bus->redirectTo()]);
    }

    public function mobileLogin(MobileLoginRequest $request, AuthBus $bus)
    {
        ['mobile' => $mobile] = $request->filldata();
        $user = $this->userService->findMobile($mobile);
        if (!$user) {
            // 手机号不存在=>直接注册
            $user = $this->userService->createWithMobile($mobile, '', '');
        }

        if ((int)$user['is_lock'] === 1) {
            return $this->error(__('账号已被锁定'));
        }

        $bus->webLogin(
            $user['id'],
            $request->has('remember'),
            is_h5() ? FrontendConstant::LOGIN_PLATFORM_H5 : FrontendConstant::LOGIN_PLATFORM_PC
        );

        return $this->data(['redirect_url' => $bus->redirectTo()]);
    }

    public function register(RegisterPasswordRequest $request)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();
        $user = $this->userService->findMobile($mobile);
        if ($user) {
            return $this->error(__('手机号已存在'));
        }
        $this->userService->createWithMobile($mobile, $password, '');

        return $this->success();
    }

    public function passwordReset(PasswordResetRequest $request)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();

        $this->userService->findPassword($mobile, $password);

        return $this->success();
    }

    public function mobileBind(MobileBindRequest $request)
    {
        ['mobile' => $mobile] = $request->filldata();
        $this->userService->bindMobile($mobile, $this->id());
        return $this->success();
    }

    public function changeMobile(MobileBindRequest $request)
    {
        ['mobile' => $mobile] = $request->filldata();
        $this->userService->changeMobile($this->id(), $mobile);
        return $this->success();
    }

    public function changePassword(MemberPasswordResetRequest $request)
    {
        ['old_password' => $oldPassword, 'new_password' => $newPassword] = $request->filldata();
        $this->userService->resetPassword($this->id(), $oldPassword, $newPassword);
        return $this->success();
    }

    public function changeAvatar(AvatarChangeRequest $request)
    {
        ['url' => $url] = $request->filldata();
        $this->userService->updateAvatar($this->id(), $url);
        return $this->success();
    }

    public function changeNickname(NicknameChangeRequest $request)
    {
        ['nick_name' => $nickName] = $request->filldata();
        $this->userService->updateNickname($this->id(), $nickName);
        return $this->success();
    }

    public function notificationMarkAsRead(ReadAMessageRequest $request)
    {
        ['id' => $id] = $request->filldata();
        $this->userService->notificationMarkAsRead($this->id(), $id);
        return $this->success();
    }

    public function notificationMarkAllAsRead()
    {
        $this->userService->notificationMarkAllAsRead($this->id());
        return $this->success();
    }

    public function inviteBalanceWithdraw(InviteBalanceWithdrawRequest $request, UserInviteBalanceServiceInterface $userInviteBalanceService)
    {
        /**
         * @var UserInviteBalanceService $userInviteBalanceService
         */

        $data = $request->filldata();
        $total = $request->post('total');
        $user = $this->userService->find($this->id());
        if ($user['invite_balance'] < $total) {
            return $this->error(__('邀请余额不足'));
        }
        $userInviteBalanceService->createCurrentUserWithdraw($data['total'], $data['channel']);
        return $this->success();
    }

    public function likeACourse($id)
    {
        $result = $this->userService->likeACourse($this->id(), $id);
        return $this->data($result);
    }

    public function recordVideo(Request $request, VideoBus $videoBus, $videoId)
    {
        // 这里前台传递的duration时间是用户播放的视频的播放位置
        // 举个例子：如果用户看到了10分10秒，这里的duration的值就是610
        $duration = (int)$request->input('duration', 0);
        if (!$duration) {
            return $this->error(__('参数错误'));
        }

        $videoBus->userVideoWatchDurationRecord($this->id(), (int)$videoId, $duration);

        return $this->success();
    }

    public function profileUpdate(Request $request)
    {
        $data = $request->all();
        $this->userService->saveProfile($this->id(), $data);
        return $this->success();
    }

    public function getPlayUrls(Request $request, BusinessState $businessState)
    {
        $data = $request->input('data');
        if (!$data) {
            return $this->error(__('参数错误'));
        }
        $data = decrypt($data);
        if (!$data) {
            return $this->error(__('参数错误'));
        }
        $time = $data['time'] ?? 0;
        if ((time() - $time) > 300) {
            return $this->error(__('参数错误'));
        }

        $isTry = (int)$data['is_try'];
        $videoId = $data['video_id'];

        $video = $this->videoService->find($videoId);
        $course = $this->courseService->find($video['course_id']);

        if ($businessState->canSeeVideo($this->user(), $course, $video) === false) {
            return $this->error(__('当前视频无法观看'));
        }

        $playUrls = get_play_url($video, $isTry ? true : false);

        if (!$playUrls) {
            return $this->error(__('系统错误'));
        }

        return $this->data($playUrls);
    }
}
