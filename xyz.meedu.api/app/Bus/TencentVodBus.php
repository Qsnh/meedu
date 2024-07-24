<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

class TencentVodBus
{

    private $appId;
    private $secretId;
    private $secretKey;
    private $callbackKey;
    private $playDomain;
    private $playKey;

    public function __construct(array $config)
    {
        $this->appId = $config['app_id'];
        $this->secretId = $config['secret_id'];
        $this->secretKey = $config['secret_key'];

        isset($config['callback_key']) && $this->callbackKey = $config['callback_key'];
        isset($config['play_domain']) && $this->playDomain = $config['play_domain'];
        isset($config['play_key']) && $this->playKey = $config['play_key'];
    }

}
