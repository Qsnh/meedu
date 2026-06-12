<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\Administrator;
use App\Meedu\SystemSetupLock;
use App\Models\AdministratorLog;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\SystemSetupRequest;

class SystemSetupController extends BaseController
{
    public function status()
    {
        if (SystemSetupLock::exists()) {
            return $this->successData(['needs_init' => false]);
        }
        $needsInit = Administrator::query()->doesntExist();
        return $this->successData(['needs_init' => $needsInit]);
    }

    public function setup(SystemSetupRequest $request)
    {
        // 三层防护:lock 文件 fail-closed(防 administrators 被清空后滥用)、
        // 廉价存在性检查(挡掉无谓的事务开销)、lockForUpdate 在空表上落 supremum gap 锁防并发。
        if (SystemSetupLock::exists()) {
            return $this->error(__('系统已完成超管初始化'));
        }

        if (Administrator::query()->exists()) {
            return $this->error(__('系统已完成超管初始化'));
        }

        $superSlug = config('meedu.administrator.super_slug');

        try {
            [$createdId, $createdEmail] = DB::transaction(function () use ($request, $superSlug) {
                if (Administrator::query()->lockForUpdate()->exists()) {
                    throw new \DomainException(__('系统已完成超管初始化'));
                }

                $super = AdministratorRole::query()->where('slug', $superSlug)->first();
                if (!$super) {
                    throw new \DomainException(__('系统角色数据缺失，请先运行 php artisan install role'));
                }

                $admin = Administrator::query()->create($request->filldata());
                $admin->roles()->attach($super->id);
                return [$admin->id, $admin->email];
            });
        } catch (\DomainException $e) {
            return $this->error($e->getMessage());
        }

        SystemSetupLock::write([
            'source' => SystemSetupLock::SOURCE_SETUP_API,
            'admin_id' => $createdId,
            'email' => $createdEmail,
            'ip' => $request->ip(),
        ]);

        // /setup 接口无登录态,显式把日志归属到新建的超管自身。
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR,
            AdministratorLog::OPT_STORE,
            ['email' => $createdEmail],
            $createdId
        );

        return $this->successData(['email' => $createdEmail]);
    }
}
