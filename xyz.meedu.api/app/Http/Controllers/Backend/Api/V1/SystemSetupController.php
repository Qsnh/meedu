<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\Administrator;
use App\Models\AdministratorLog;
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

        try {
            $createdEmail = DB::transaction(function () use ($request, $superSlug) {
                // InnoDB 在空表上的 SELECT ... FOR UPDATE 仍会落 supremum gap 锁,
                // 阻止并发事务插入;email 字段本身也有 UNIQUE 索引做兜底。
                if (Administrator::query()->lockForUpdate()->exists()) {
                    throw new \DomainException(__('系统已完成超管初始化'));
                }

                $super = AdministratorRole::query()->where('slug', $superSlug)->first();
                if (!$super) {
                    throw new \DomainException(__('系统角色数据缺失，请先运行 php artisan install role'));
                }

                $admin = Administrator::query()->create($request->filldata());
                $admin->roles()->attach($super->id);
                return $admin->email;
            });
        } catch (\DomainException $e) {
            return $this->error($e->getMessage());
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_ADMINISTRATOR,
            AdministratorLog::OPT_STORE,
            ['email' => $createdEmail]
        );

        return $this->successData(['email' => $createdEmail]);
    }
}
