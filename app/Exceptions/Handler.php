<?php

/*
 * This file is part of the Qsnh/meedu.
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

    public function render($request, \Throwable $exception)
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
                    return $this->error(__('错误'), $code);
                }
            }
        }

        return parent::render($request, $exception);
    }
}
