<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

define('ECS_ROLE_EXPIRE_TIME', 3600);

class EcsRamRoleService
{
    private $clientProfile;
    private $lastClearTime = null;
    private $sessionCredential = null;

    public function __construct($clientProfile)
    {
        $this->clientProfile = $clientProfile;
    }

    public function getSessionCredential()
    {
        if ($this->lastClearTime != null && $this->sessionCredential != null) {
            $now = time();
            $elapsedTime = $now - $this->lastClearTime;
            if ($elapsedTime <= ECS_ROLE_EXPIRE_TIME * 0.8) {
                return $this->sessionCredential;
            }
        }

        $credential = $this->assumeRole();

        if ($credential == null) {
            return null;
        }

        $this->sessionCredential = $credential;
        $this->lastClearTime = time();

        return $credential;
    }

    private function assumeRole()
    {
        $ecsRamRoleCredential = $this->clientProfile->getCredential();

        $requestUrl = 'http://100.100.100.200/latest/meta-data/ram/security-credentials/'.$ecsRamRoleCredential->getRoleName();

        $httpResponse = HttpHelper::curl($requestUrl, 'GET', null, null);
        if (! $httpResponse->isSuccess()) {
            return null;
        }

        $respObj = json_decode($httpResponse->getBody());

        $code = $respObj->Code;
        if ($code != 'Success') {
            return null;
        }

        $sessionAccessKeyId = $respObj->AccessKeyId;
        $sessionAccessKeySecret = $respObj->AccessKeySecret;
        $securityToken = $respObj->SecurityToken;

        return new Credential($sessionAccessKeyId, $sessionAccessKeySecret, $securityToken);
    }
}
