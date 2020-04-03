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
use Illuminate\Http\Request;
use App\Events\UserLoginEvent;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use Illuminate\Support\Facades\Auth;
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

    /**
     * 课程评论.
     *
     * @param CourseOrVideoCommentCreateRequest $request
     * @param $courseId
     *
     * @return array
     */
    public function courseCommentHandler(CourseOrVideoCommentCreateRequest $request, $courseId)
    {
        $course = $this->courseService->find($courseId);
        ['content' => $content] = $request->filldata();
        $comment = $this->courseCommentService->create($course['id'], $content);
        $user = $this->userService->find(Auth::id(), ['role']);

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

    /**
     * 视频评论.
     *
     * @param CourseOrVideoCommentCreateRequest $request
     * @param $videoId
     *
     * @return array
     */
    public function videoCommentHandler(CourseOrVideoCommentCreateRequest $request, $videoId)
    {
        $video = $this->videoService->find($videoId);
        ['content' => $content] = $request->filldata();
        $comment = $this->videoCommentService->create($video['id'], $content);
        $user = $this->userService->find(Auth::id(), ['role']);

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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

    /**
     * @param LoginPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordLogin(LoginPasswordRequest $request)
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
        Auth::loginUsingId($user['id'], $request->has('remember'));

        event(new UserLoginEvent($user['id']));

        return $this->data(['redirect_url' => $this->redirectTo()]);
    }

    /**
     * @param MobileLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobileLogin(MobileLoginRequest $request)
    {
        ['mobile' => $mobile] = $request->filldata();
        $user = $this->userService->findMobile($mobile);
        if (!$user) {
            // 直接注册
            $user = $this->userService->createWithMobile($mobile, '', '');
        }
        if ($user['is_lock'] === FrontendConstant::YES) {
            return $this->error(__('current user was locked,please contact administrator'));
        }
        Auth::loginUsingId($user['id'], $request->has('remember'));

        event(new UserLoginEvent($user['id']));

        return $this->data(['redirect_url' => $this->redirectTo()]);
    }

    /**
     * @param RegisterPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param PasswordResetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordReset(PasswordResetRequest $request)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();

        $this->userService->findPassword($mobile, $password);

        return $this->success();
    }

    /**
     * @param MobileBindRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \App\Exceptions\ServiceException
     */
    public function mobileBind(MobileBindRequest $request)
    {
        ['mobile' => $mobile] = $request->filldata();
        $this->userService->bindMobile($mobile);
        return $this->success();
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed|string
     */
    protected function redirectTo()
    {
        $callbackUrl = session()->has(FrontendConstant::LOGIN_CALLBACK_URL_KEY) ?
            session(FrontendConstant::LOGIN_CALLBACK_URL_KEY) : url('/');
        return $callbackUrl;
    }

    /**
     * @param MemberPasswordResetRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function changePassword(MemberPasswordResetRequest $request)
    {
        ['old_password' => $oldPassword, 'new_password' => $newPassword] = $request->filldata();
        $this->userService->resetPassword(Auth::id(), $oldPassword, $newPassword);
        return $this->success();
    }

    /**
     * @param AvatarChangeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeAvatar(AvatarChangeRequest $request)
    {
        ['url' => $url] = $request->filldata();
        $this->userService->updateAvatar(Auth::id(), $url);
        return $this->success();
    }

    /**
     * @param NicknameChangeRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ServiceException
     */
    public function changeNickname(NicknameChangeRequest $request)
    {
        ['nick_name' => $nickName] = $request->filldata();
        $this->userService->updateNickname(Auth::id(), $nickName);
        return $this->success();
    }

    /**
     * @param ReadAMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function notificationMarkAsRead(ReadAMessageRequest $request)
    {
        ['id' => $id] = $request->filldata();
        $this->userService->notificationMarkAsRead(Auth::id(), $id);
        return $this->success();
    }

    /**
     * @param InviteBalanceWithdrawRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ServiceException
     */
    public function inviteBalanceWithdraw(InviteBalanceWithdrawRequest $request)
    {
        $data = $request->filldata();
        $total = $request->post('total');
        $user = $this->userService->find(Auth::id());
        if ($user['invite_balance'] < $total) {
            return $this->error(__('Insufficient invite balance'));
        }
        $this->userInviteBalanceService->createCurrentUserWithdraw($data['total'], $data['channel']);
        return $this->success();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeACourse($id)
    {
        $result = $this->userService->likeACourse(Auth::id(), $id);
        return $this->data($result);
    }
}
