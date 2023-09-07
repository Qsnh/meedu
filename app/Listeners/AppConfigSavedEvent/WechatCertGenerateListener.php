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

class WechatCertGenerateListener
{

    private $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    public function handle(AppConfigSavedEvent $event)
    {
        // 分下面几种情况
        // 1.原先未配置，现在配置了
        // 2.原先未配置，现在也没有配置 -> 跳过
        // 3.原先已配置，保持原样未修改 -> 跳过
        // 4.原先已配置，修改成新的配置
        // 5.原先已配置，清空了配置

        if (isset($event->newConfig[C::WECHAT_PAY_CERT_CLIENT_KEY])) {
            $oldCertClient = $event->oldConfig[C::WECHAT_PAY_CERT_CLIENT_KEY] ?? '';
            $newCertClient = $event->newConfig[C::WECHAT_PAY_CERT_CLIENT_KEY];

            $this->certClientHandle($newCertClient, $oldCertClient);
        }

        if (isset($event->newConfig[C::WECHAT_PAY_CERT_KEY_KEY])) {
            $oldCertKey = $event->oldConfig[C::WECHAT_PAY_CERT_KEY_KEY] ?? '';
            $newCertKey = $event->newConfig[C::WECHAT_PAY_CERT_KEY_KEY];
            $this->certKeyHandle($newCertKey, $oldCertKey);
        }
    }

    private function certClientHandle($new, $old)
    {
        if ($old === $new) {
            return;
        }

        $path = storage_path(C::WECHAT_PAY_CERT_CLIENT_PATH);
        if (!$new) {
            // 清空了配置
            if (file_exists($path)) {
                @unlink($path);
            }
            $this->setting->put([C::WECHAT_PAY_CERT_CLIENT_KEY => '']);
            return;
        }

        // 更新了配置
        file_put_contents($path, $new);
        $this->setting->put([C::WECHAT_PAY_CERT_CLIENT_KEY => $path]);
    }

    private function certKeyHandle($new, $old)
    {
        if ($old === $new) {
            return;
        }

        $path = storage_path(C::WECHAT_PAY_CERT_KEY_KEY_PATH);
        if (!$new) {
            // 清空了配置
            if (file_exists($path)) {
                @unlink($path);
            }
            $this->setting->put([C::WECHAT_PAY_CERT_KEY_KEY => '']);
            return;
        }

        // 更新了配置
        file_put_contents($path, $new);
        $this->setting->put([C::WECHAT_PAY_CERT_KEY_KEY => $path]);
    }
}
