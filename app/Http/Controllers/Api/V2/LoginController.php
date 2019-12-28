<?php


namespace App\Http\Controllers\Api\V2;


use App\Constant\ApiV2Constant;
use App\Http\Requests\ApiV2\PasswordLoginRequest;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Services\UserService;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 * @package App\Http\Controllers\Api\V2
 */
class LoginController extends BaseController
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
     * @OA\Post(
     *     path="/login/password",
     *     summary="密码登录",
     *     @OA\RequestBody(description="",@OA\JsonContent(
     *         @OA\Property(property="mobile",description="手机号",type="string"),
     *         @OA\Property(property="password",description="密码",type="string"),
     *     )),
     *     @OA\RequestBody(request="password",description="密码",required=true,@OA\Schema(type="string")),
     *     @OA\Response(
     *         description="",response=200,
     *         @OA\JsonContent(
     *             @OA\Property(property="code",type="integer",description="状态码"),
     *             @OA\Property(property="message",type="string",description="消息"),
     *             @OA\Property(property="data",type="object",description="",
     *                 @OA\Property(property="token",type="string",description="token"),
     *             ),
     *         )
     *     )
     * )
     *
     * @param PasswordLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordLogin(PasswordLoginRequest $request)
    {
        [
            'mobile' => $mobile,
            'password' => $password,
        ] = $request->filldata();
        $user = $this->userService->passwordLogin($mobile, $password);
        if (!$user) {
            return $this->error(ApiV2Constant::MOBILE_OR_PASSWORD_ERROR);
        }
        $token = Auth::guard($this->guard)->tokenById($user['id']);
        return $this->success(compact('token'));
    }

}