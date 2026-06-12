<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu;

use Illuminate\Support\Facades\Log;

/**
 * 超管初始化文件锁(setup.lock)集中管理。
 *
 * 与 install.lock 同构,作为"超管已初始化"的权威哨兵:
 *  - SystemSetupController 入口 fail-closed
 *  - 老站点登录路径自愈
 *  - 运维通过 artisan 命令显式管理
 */
class SystemSetupLock
{
    public const SOURCE_SETUP_API = 'setup_api';
    public const SOURCE_LOGIN_HEAL = 'login_heal';
    public const SOURCE_CLI = 'cli';

    public static function path(): string
    {
        return storage_path('setup.lock');
    }

    public static function exists(): bool
    {
        return file_exists(self::path());
    }

    /**
     * 原子写入 lock 文件:tmp + rename,避免半写文件被后续校验误读。
     * 写入失败仅记录告警,由上层决定是否拦截业务。
     */
    public static function write(array $payload): bool
    {
        $payload = array_merge(['ts' => time()], $payload);
        $lockPath = self::path();
        $tmpPath = $lockPath . '.tmp';

        $written = @file_put_contents(
            $tmpPath,
            json_encode($payload, JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );
        if ($written === false || !@rename($tmpPath, $lockPath)) {
            @unlink($tmpPath);
            Log::warning('setup.lock 写入失败,请人工执行 php artisan setup:lock 补写', [
                'storage_path' => $lockPath,
                'payload' => $payload,
            ]);
            return false;
        }
        return true;
    }

    public static function delete(): bool
    {
        if (!self::exists()) {
            return true;
        }
        return @unlink(self::path());
    }
}
