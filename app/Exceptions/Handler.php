<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Exceptions;

use Illuminate\Support\Str;
use Illuminate\Auth\AuthenticationException;
use App\Exceptions\Backend\ValidateException;
use App\Http\Controllers\Api\V2\Traits\ResponseTrait;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
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
        ServiceException::class,
        ValidateException::class,
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

    public function render($request, \Throwable $e)
    {
        // 如果异常自定义了响应的方法则直接交给框架处理
        // 也就是直接走异常自定义的 render 方法
        if (method_exists($e, 'render')) {
            return parent::render($request, $e);
        }

        $isReqOnBackend = Str::startsWith($request->getUri(), '/backend');

        $errCode = 1;
        $errMsg = $isReqOnBackend ? $e->getMessage() : __('错误');
        if ($e instanceof AuthenticationException) {//未登录异常
            $errCode = 401;
            $errMsg = __('请登录');
        } elseif ($e instanceof ThrottleRequestsException) {//API限流异常
            $errCode = 429;
            $errMsg = __('请稍后再试');
        }

        if ($isReqOnBackend) {
            return response()->json([
                'status' => $errCode,
                'message' => $errMsg,
            ]);
        }

        return $this->error($errMsg, $errCode);
    }
}
