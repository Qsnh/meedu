<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\Administrator;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\SystemSetupRequest;

class SystemSetupController extends BaseController
{
    public function status()
    {
        $needsInit = Administrator::query()->doesntExist();
        return $this->successData(['needs_init' => $needsInit]);
    }

    public function setup(SystemSetupRequest $request)
    {
        $superSlug = config('meedu.administrator.super_slug');
        $errorMessage = null;
        $createdEmail = null;

        DB::transaction(function () use ($request, $superSlug, &$errorMessage, &$createdEmail) {
            $exists = Administrator::query()->lockForUpdate()->exists();
            if ($exists) {
                $errorMessage = '系统已完成超管初始化';
                return;
            }

            $super = AdministratorRole::query()->where('slug', $superSlug)->first();
            if (!$super) {
                $errorMessage = '系统角色数据缺失，请先运行 php artisan install role';
                return;
            }

            $payload = $request->filldata();
            $admin = Administrator::query()->create($payload);
            $admin->roles()->attach($super->id);
            $createdEmail = $admin->email;
        });

        if ($errorMessage !== null) {
            return $this->error($errorMessage);
        }

        return $this->successData(['email' => $createdEmail]);
    }
}
