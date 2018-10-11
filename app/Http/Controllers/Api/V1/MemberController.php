<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiV1Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MemberRepository;
use App\Http\Resources\Member\OrderResource;
use App\Http\Resources\Member\MessageResource;
use App\Http\Resources\Member\RoleBuyResource;
use App\Http\Resources\RechargePaymentResource;
use App\Http\Resources\Member\BuyVideosResource;
use App\Http\Resources\Member\JoinCourseRecourse;
use App\Http\Requests\Frontend\Member\AvatarChangeRequest;
use App\Http\Requests\Frontend\Member\MemberPasswordResetRequest;

class MemberController extends Controller
{
    /**
     * 密码修改.
     *
     * @param MemberRepository           $repository
     * @param MemberPasswordResetRequest $request
     *
     * @throws ApiV1Exception
     */
    public function passwordChangeHandler(MemberRepository $repository, MemberPasswordResetRequest $request)
    {
        [$oldPassword, $newPassword] = $request->filldata();
        if (! $repository->passwordChangeHandler($oldPassword, $newPassword)) {
            throw new ApiV1Exception($repository->errors);
        }
    }

    /**
     * 充值记录.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function rechargeRecords(MemberRepository $repository)
    {
        return RechargePaymentResource::collection($repository->rechargeRecords());
    }

    /**
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function joinCourses(MemberRepository $repository)
    {
        $records = $repository->buyCourses();

        return JoinCourseRecourse::collection($records);
    }

    /**
     * 已购买视频.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function buyVideos(MemberRepository $repository)
    {
        $videos = $repository->buyVideos();

        return BuyVideosResource::collection($videos);
    }

    /**
     * 我的订单.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function orders(MemberRepository $repository)
    {
        $orders = $repository->orders();

        return OrderResource::collection($orders);
    }

    /**
     * VIP购买记录.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function roleBuyRecords(MemberRepository $repository)
    {
        $records = $repository->roleBuyRecords();

        return RoleBuyResource::collection($records);
    }

    /**
     * 我的消息.
     *
     * @param MemberRepository $repository
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function messages(MemberRepository $repository)
    {
        $messages = $repository->messages();

        return MessageResource::collection($messages);
    }

    /**
     * 头像更换.
     *
     * @param AvatarChangeRequest $request
     * @param MemberRepository    $repository
     */
    public function avatarChange(AvatarChangeRequest $request, MemberRepository $repository)
    {
        [$path, $url] = $request->filldata();
        $repository->avatarChangeHandler(Auth::user(), $url);
    }

    /**
     * 用户资料.
     *
     * @return UserResource
     */
    public function profile()
    {
        return new UserResource(Auth::user());
    }
}
