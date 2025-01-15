<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use Illuminate\Filesystem\Filesystem;
use App\Meedu\ServiceV2\Models\UserLoginRecord;
use App\Meedu\ServiceV2\Models\UserUploadImage;

class LogController extends BaseController
{
    public function admin(Request $request)
    {
        $adminId = (int)$request->input('admin_id');
        $module = $request->input('module');
        $opt = $request->input('opt');

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SYSTEM_LOG,
            AdministratorLog::OPT_VIEW,
            compact('adminId', 'module', 'opt')
        );

        $logs = AdministratorLog::query()
            ->when($adminId, function ($query) use ($adminId) {
                $query->where('admin_id', $adminId);
            })
            ->when($module, function ($query) use ($module) {
                $query->where('module', $module);
            })
            ->when($opt, function ($query) use ($opt) {
                $query->where('opt', $opt);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        return $this->successData([
            'total' => $logs->total(),
            'data' => $logs->items(),
        ]);
    }

    public function userLogin(Request $request)
    {
        $userId = (int)$request->input('user_id');

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SYSTEM_LOG,
            AdministratorLog::OPT_VIEW,
            compact('userId')
        );

        $list = UserLoginRecord::query()
            ->select(['id', 'user_id', 'ip', 'platform', 'ua', 'iss', 'jti', 'exp', 'is_logout', 'created_at'])
            ->with(['user:id,nick_name,avatar'])
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        return $this->successData([
            'data' => $list->items(),
            'total' => $list->total(),
        ]);
    }

    public function uploadImages(Request $request)
    {
        $userId = (int)$request->input('user_id');

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SYSTEM_LOG,
            AdministratorLog::OPT_VIEW,
            compact('userId')
        );

        $list = UserUploadImage::query()
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        return $this->successData([
            'data' => $list->items(),
            'total' => $list->total(),
        ]);
    }

    public function runtime()
    {
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SYSTEM_LOG,
            AdministratorLog::OPT_VIEW
        );

        $logPath = storage_path('logs/laravel.log');

        $data = [];

        if (file_exists($logPath)) {
            $handle = fopen($logPath, 'r');
            if (!$handle) {
                return $this->error(__('无法读取日志文件'));
            }


            $lineCounter = 0;
            $pos = -1;
            $buffer = '';

            fseek($handle, -1, SEEK_END);

            while (-1 !== fseek($handle, $pos, SEEK_END)) {
                $char = fgetc($handle);
                $buffer .= $char;

                if ($char === "\n") {
                    $lineCounter++;
                    if ($lineCounter >= 1000) {
                        break;
                    }
                }

                $pos--;
            }

            fclose($handle);

            if ($buffer) {
                $buffer = strrev($buffer);
                $data = array_reverse(explode("\n", $buffer));
            }
        }

        return $this->successData([
            'latest_content' => $data,
        ]);
    }

    public function destroy(Filesystem $filesystem, $sign)
    {
        $sign = strtolower($sign);
        if (!in_array($sign, ['runtime', 'admin', 'user-login', 'upload-image'])) {
            return $this->error(__('参数错误'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SYSTEM_LOG,
            AdministratorLog::OPT_DESTROY,
            compact('sign')
        );

        if ('runtime' === $sign) {
            $filesystem->delete(storage_path('logs/laravel.log'));
        } elseif ('admin' === $sign) {
            AdministratorLog::query()->delete();
        } elseif ('user-login' === $sign) {
            UserLoginRecord::query()->delete();
        } elseif ('upload-image' === $sign) {
            UserUploadImage::query()->delete();
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_SYSTEM_LOG,
            AdministratorLog::OPT_DESTROY,
            compact('sign')
        );

        return $this->success();
    }
}
