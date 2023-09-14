<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Exceptions;

use Illuminate\Support\Str;
use App\Constant\ApiV2Constant;
use App\Constant\BackendApiConstant;
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
        ApiV2Exception::class,
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
        if ($e instanceof ServiceException || $e instanceof ApiV2Exception) {
            return parent::render($request, $e);
        }

        // 后台的异常错误
        if (Str::contains($request->getUri(), '/backend/api/v1')) {
            $code = BackendApiConstant::ERROR_CODE;
            if ($e instanceof AuthenticationException) {//未登录异常
                $code = BackendApiConstant::NO_AUTH_CODE;
            } elseif ($e instanceof ThrottleRequestsException) {//限流异常
                $code = 429;
            }

            return response()->json([
                'status' => $code,
                'message' => $e->getMessage(),
            ]);
        }

        if (Str::contains($request->getUri(), '/api/v2')) {
            $code = ApiV2Constant::ERROR_CODE;//默认的错误code
            if ($e instanceof AuthenticationException) {//未登录code=401
                $code = ApiV2Constant::ERROR_NO_AUTH_CODE;
            } elseif ($e instanceof ThrottleRequestsException) {
                $code = 429;
            }
            return $this->error(__('错误'), $code);
        }

        return parent::render($request, $e);
    }
}
