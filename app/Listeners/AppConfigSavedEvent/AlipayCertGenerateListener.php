<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AppConfigSavedEvent;

use App\Events\AppConfigSavedEvent;
use App\Constant\ConfigConstant as C;

class AlipayCertGenerateListener
{
    public function handle(AppConfigSavedEvent $event)
    {
        if (isset($event->newConfig[C::ALIPAY_ROOT_CERT_KEY])) {
            $new = $event->newConfig[C::ALIPAY_ROOT_CERT_KEY];
            $old = $event->oldConfig[C::ALIPAY_ROOT_CERT_KEY] ?? '';

            $this->rootCertHandle($new, $old);
        }

        if (isset($event->newConfig[C::ALIPAY_APP_CERT_PUBLIC_KEY_KEY])) {
            $new = $event->newConfig[C::ALIPAY_APP_CERT_PUBLIC_KEY_KEY];
            $old = $event->oldConfig[C::ALIPAY_APP_CERT_PUBLIC_KEY_KEY] ?? '';
            $this->appCertPublicKeyHandle($new, $old);
        }
    }

    private function rootCertHandle($new, $old)
    {
        if ($old === $new) {
            return;
        }

        $path = storage_path(C::ALIPAY_ROOT_CERT_PATH);
        if (!$new) {
            // 清空了配置
            if (file_exists($path)) {
                @unlink($path);
            }
            return;
        }

        // 更新了配置
        file_put_contents($path, $new);
    }

    private function appCertPublicKeyHandle($new, $old)
    {
        if ($old === $new) {
            return;
        }

        $path = storage_path(C::ALIPAY_APP_CERT_PUBLIC_KEY_PATH);
        if (!$new) {
            // 清空了配置
            if (file_exists($path)) {
                @unlink($path);
            }
            return;
        }

        // 更新了配置
        file_put_contents($path, $new);
    }
}
