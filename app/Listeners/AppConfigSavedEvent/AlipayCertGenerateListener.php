<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AppConfigSavedEvent;

use App\Meedu\Setting;
use App\Events\AppConfigSavedEvent;
use App\Constant\ConfigConstant as C;

class AlipayCertGenerateListener
{

    private $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function handle(AppConfigSavedEvent $event)
    {
        // 如果有值就意味着重新配置

        if (isset($event->newConfig[C::ALIPAY_ROOT_CERT_KEY])) {
            $new = $event->newConfig[C::ALIPAY_ROOT_CERT_KEY];
            $this->rootCertHandle($new);
        }

        if (isset($event->newConfig[C::ALIPAY_APP_CERT_PUBLIC_KEY_KEY])) {
            $new = $event->newConfig[C::ALIPAY_APP_CERT_PUBLIC_KEY_KEY];
            $this->appCertPublicKeyHandle($new);
        }
    }

    private function rootCertHandle($new)
    {
        $path = storage_path(C::ALIPAY_ROOT_CERT_PATH);
        if (!$new) {
            // 清空了配置
            if (file_exists($path)) {
                @unlink($path);
            }
            $this->setting->put([C::ALIPAY_ROOT_CERT_KEY => '']);
            return;
        }

        // 更新了配置
        file_put_contents($path, $new);
        $this->setting->put([C::ALIPAY_ROOT_CERT_KEY => $path]);
    }

    private function appCertPublicKeyHandle($new)
    {
        $path = storage_path(C::ALIPAY_APP_CERT_PUBLIC_KEY_PATH);
        if (!$new) {
            // 清空了配置
            if (file_exists($path)) {
                @unlink($path);
            }
            $this->setting->put([C::ALIPAY_APP_CERT_PUBLIC_KEY_KEY => '']);
            return;
        }

        // 更新了配置
        file_put_contents($path, $new);
        $this->setting->put([C::ALIPAY_APP_CERT_PUBLIC_KEY_KEY => $path]);
    }
}
