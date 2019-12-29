<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Api\V2;

use Illuminate\Support\Facades\Auth;
use App\Services\Member\Services\UserService;
use App\Http\Requests\ApiV2\AvatarChangeRequest;
use App\Http\Requests\ApiV2\PasswordChangeRequest;
use App\Services\Member\Interfaces\UserServiceInterface;

/**
 * @OpenApi\Annotations\Schemas(
 *     @OA\Schema(
 *         schema="User",
 *         type="object",
 *         title="用户信息",
 *         @OA\Property(property="id",type="int64",description="用户id"),
 *         @OA\Property(property="avatar",type="string",description="头像"),
 *         @OA\Property(property="nick_name",type="string",description="昵称"),
 *         @OA\Property(property="property",type="string",description="手机号"),
 *         @OA\Property(property="role_id",type="int32",description="会员套餐id"),
 *         @OA\Property(property="role_expired_at",type="string",description="会员套餐到期时间"),
 *         @OA\Property(property="role",type="object",ref="#/components/schemas/Role"),
 *     ),
 *     @OA\Schema(
 *         schema="Role",
 *         type="object",
 *         title="会员套餐",
 *         @OA\Property(property="id",type="int32",description="套餐id"),
 *         @OA\Property(property="name",type="string",description="套餐名"),
 *         @OA\Property(property="description",type="string",description="套餐描述"),
 *     ),
 * )
 */

/**
 * Class MemberController.
 */
class MemberController extends BaseController
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/member/detail",
     *     summary="用户信息",
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",ref="#/components/schemas/User"),
     *         )
     *     )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail()
    {
        $user = $this->userService->find(Auth::guard($this->guard)->id());

        return $this->data($user);
    }

    /**
     * @OA\Post(
     *     path="/member/password",
     *     summary="修改密码",
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="mobile_code",description="手机短信验证码",type="string"),
     *         @OA\Property(property="password",description="密码",type="string"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description=""),
     *         )
     *     )
     * )
     *
     * @param PasswordChangeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordChange(PasswordChangeRequest $request)
    {
        ['password' => $password] = $request->filldata();
        $this->userService->changePassword($this->id(), $password);

        return $this->success();
    }

    /**
     * @OA\Post(
     *     path="/member/avatar",
     *     summary="修改头像",
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="file",description="图片文件",type="file"),
     *     )),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description=""),
     *         )
     *     )
     * )
     *
     * @param AvatarChangeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatarChange(AvatarChangeRequest $request)
    {
        ['url' => $url] = $request->filldata();
        $this->userService->updateAvatar($this->id(), $url);

        return $this->success();
    }
}
