<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Meedu\SystemSetupLock;
use App\Models\Administrator;
use App\Models\AdministratorLog;
use App\Models\AdministratorRole;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Backend\SystemSetupRequest;

class SystemSetupController extends BaseController
{
    public function status()
    {
        // setup.lock 是超管初始化完成的权威哨兵,文件存在直接短路 DB 查询。
        if (SystemSetupLock::exists()) {
            return $this->successData(['needs_init' => false]);
        }
        $needsInit = Administrator::query()->doesntExist();
        return $this->successData(['needs_init' => $needsInit]);
    }

    public function setup(SystemSetupRequest $request)
    {
        // 第一道防线:setup.lock 文件存在即拒绝,fail-closed。
        // 即便 administrators 表被清空,只要 lock 文件健在,公开路由也无法被滥用重建超管。
        if (SystemSetupLock::exists()) {
            return $this->error(__('系统已完成超管初始化'));
        }

        // 第二道防线:廉价的索引存在性检查,避免恶意/误发的 POST 都付出事务+行锁开销。
        if (Administrator::query()->exists()) {
            return $this->error(__('系统已完成超管初始化'));
        }

        $superSlug = config('meedu.administrator.super_slug');

        try {
            [$createdId, $createdEmail] = DB::transaction(function () use ($request, $superSlug) {
                // 第三道防线:InnoDB 在空表上的 SELECT ... FOR UPDATE 仍会落 supremum gap 锁,
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
                return [$admin->id, $admin->email];
            });
        } catch (\DomainException $e) {
            return $this->error($e->getMessage());
        }

        // 事务已提交即超管已落库,无论 lock 写入是否成功都必须返回成功;
        // 写入失败由 helper 内部 Log::warning,由运维通过 ops 手段补写。
        SystemSetupLock::write([
            'source' => 'setup_api',
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
