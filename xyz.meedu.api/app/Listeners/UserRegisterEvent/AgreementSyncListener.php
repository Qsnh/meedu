<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserRegisterEvent;

use App\Events\UserRegisterEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\ServiceV2\Services\AgreementServiceInterface;

class AgreementSyncListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $agreementService;

    public function __construct(AgreementServiceInterface $agreementService)
    {
        $this->agreementService = $agreementService;
    }

    public function handle(UserRegisterEvent $event)
    {
        try {
            // 获取必须同意的协议
            $requiredAgreements = $this->agreementService->getRequiredAgreements();

            if (empty($requiredAgreements)) {
                return;
            }

            // 为新注册用户自动记录协议同意状态
            foreach ($requiredAgreements as $agreement) {
                $this->agreementService->recordUserAgreement(
                    $event->userId,
                    $agreement['id'],
                    $event->extra['ip'] ?? '',
                    $event->extra['ua'] ?? '',
                    $event->extra['platform'] ?? ''
                );
            }

        } catch (\Exception $e) {
            // 记录错误日志，但不影响注册流程
            Log::error('协议同步失败 - 用户注册', [
                'user_id' => $event->userId,
                'extra' => $event->extra,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }
}
