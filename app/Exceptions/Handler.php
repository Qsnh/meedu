<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Str;
use App\Constant\ApiV2Constant;
use App\Businesses\BusinessState;
use App\Constant\BackendApiConstant;
use Illuminate\Auth\AuthenticationException;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ApiV2Exception::class,
        ServiceException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if (!($exception instanceof ServiceException) && $request->wantsJson()) {
            // 后台的异常错误
            if (Str::contains($request->getUri(), '/backend/api/v1')) {
                $code = BackendApiConstant::ERROR_CODE;
                $exception instanceof AuthenticationException && $code = BackendApiConstant::NO_AUTH_CODE;
                return response()->json([
                    'status' => $code,
                    'message' => $exception->getMessage(),
                ]);
            }
            if (!($exception instanceof ApiV2Exception)) {
                // apiV2异常错误
                if (Str::contains($request->getUri(), '/api/v2')) {
                    $code = ApiV2Constant::ERROR_CODE;
                    $exception instanceof AuthenticationException && $code = ApiV2Constant::ERROR_NO_AUTH_CODE;
                    return $this->error(__('error'), $code);
                }
            }
        }

        // 未登录异常处理
        // 当用户是H5访问，开启了微信授权登录，微信浏览器中，且url中未包含跳过登录标识
        if ($exception instanceof AuthenticationException) {
            /**
             * @var BusinessState $busState
             */
            $busState = app()->make(BusinessState::class);

            if (
                $busState->isEnabledMpOAuthLogin() &&
                is_h5() &&
                is_wechat() &&
                !$request->has('skip_wechat')
            ) {
                $redirect = $request->fullUrl();
                return redirect(url_append_query(route('login.wechat.oauth'), ['redirect' => $redirect]));
            }
        }

        return parent::render($request, $exception);
    }
}
