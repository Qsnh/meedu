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
     * @var VideoCommentService
     */
    protected $videoCommentService;
    /**
     * @var CourseCommentService
     */
    protected $courseCommentService;
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
    /**
     * @var PromoCodeService
     */
    protected $promoCodeService;
    protected $businessState;

    /**
     * @var UserInviteBalanceService
     */
    protected $userInviteBalanceService;

    public function __construct(
        VideoCommentServiceInterface $videoCommentService,
        CourseCommentServiceInterface $courseCommentService,
        UserServiceInterface $userService,
        VideoServiceInterface $videoService,
        CourseServiceInterface $courseService,
        PromoCodeServiceInterface $promoCodeService,
        BusinessState $businessState,
        UserInviteBalanceServiceInterface $userInviteBalanceService
    ) {
        $this->videoCommentService = $videoCommentService;
        $this->courseCommentService = $courseCommentService;
        $this->userService = $userService;
        $this->videoService = $videoService;
        $this->courseService = $courseService;
        $this->promoCodeService = $promoCodeService;
        $this->businessState = $businessState;
        $this->userInviteBalanceService = $userInviteBalanceService;
    }

    public function courseCommentHandler(CourseOrVideoCommentCreateRequest $request, $courseId)
    {
        $user = $this->user();
        $course = $this->courseService->find($courseId);
        if ($this->businessState->courseCanComment($user, $course) === false) {
            return $this->error(__('course cant comment'));
        }

        ['content' => $content] = $request->filldata();
        $comment = $this->courseCommentService->create($course['id'], $content);

        $user = $this->userService->find($this->id(), ['role']);

        return $this->data([
            'content' => $comment['render_content'],
            'created_at' => Carbon::parse($comment['created_at'])->diffForHumans(),
            'user' => [
                'nick_name' => $user['nick_name'],
                'avatar' => $user['avatar'],
                'role' => $user['role'] ? $user['role']['name'] : '免费会员',
            ],
        ]);
    }

    public function videoCommentHandler(CourseOrVideoCommentCreateRequest $request, $videoId)
    {
        $video = $this->videoService->find($videoId);
        if ($this->businessState->videoCanComment($this->user(), $video) === false) {
            return $this->error(__('video cant comment'));
        }
        ['content' => $content] = $request->filldata();
        $comment = $this->videoCommentService->create($video['id'], $content);
        $user = $this->userService->find($this->id(), ['role']);

        return $this->data([
            'content' => $comment['render_content'],
            'created_at' => Carbon::parse($comment['created_at'])->diffForHumans(),
            'user' => [
                'nick_name' => $user['nick_name'],
                'avatar' => $user['avatar'],
                'role' => $user['role'] ? $user['role']['name'] : '免费会员',
            ],
        ]);
    }

    public function promoCodeCheck(Request $request)
    {
        $promoCode = $request->input('promo_code');
        if (!$promoCode) {
            return $this->error(__('error'));
        }
        $code = $this->promoCodeService->findCode($promoCode);
        if (!$code) {
            return $this->error(__('promo code not exists'));
        }
        if ($code['expired_at'] && Carbon::now()->gt($code['expired_at'])) {
            return $this->error(__('promo code has expired'));
        }
        if (!$this->businessState->promoCodeCanUse($code)) {
            return $this->error(__('user cant use this promo code'));
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
            return $this->error(__('mobile not exists or password error'));
        }
        if ($user['is_lock'] === FrontendConstant::YES) {
            return $this->error(__('current user was locked,please contact administrator'));
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

        if ($user['is_lock'] === FrontendConstant::YES) {
            return $this->error(__('current user was locked,please contact administrator'));
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
            'nick_name' => $nickname,
        ] = $request->filldata();
        $user = $this->userService->findNickname($nickname);
        if ($user) {
            return $this->error(__('nick_name.unique'));
        }
        $user = $this->userService->findMobile($mobile);
        if ($user) {
            return $this->error(__('mobile.unique'));
        }
        $this->userService->createWithMobile($mobile, $password, $nickname);

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
        $this->userService->bindMobile($mobile);
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

    public function inviteBalanceWithdraw(InviteBalanceWithdrawRequest $request)
    {
        $data = $request->filldata();
        $total = $request->post('total');
        $user = $this->userService->find($this->id());
        if ($user['invite_balance'] < $total) {
            return $this->error(__('Insufficient invite balance'));
        }
        $this->userInviteBalanceService->createCurrentUserWithdraw($data['total'], $data['channel']);
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
            return $this->error(__('params error'));
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
}
