<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

define('STS_PRODUCT_NAME', 'Sts');
define('STS_DOMAIN', 'sts.aliyuncs.com');
define('STS_VERSION', '2015-04-01');
define('STS_ACTION', 'AssumeRole');
define('STS_REGION', 'cn-hangzhou');
define('ROLE_ARN_EXPIRE_TIME', 3600);

class AssumeRoleRequest extends RpcAcsRequest
{
    public function __construct($roleArn, $roleSessionName)
    {
        parent::__construct(STS_PRODUCT_NAME, STS_VERSION, STS_ACTION);

        $this->queryParameters['RoleArn'] = $roleArn;
        $this->queryParameters['RoleSessionName'] = $roleSessionName;
        $this->queryParameters['DurationSeconds'] = ROLE_ARN_EXPIRE_TIME;
        $this->setRegionId(ROLE_ARN_EXPIRE_TIME);
        $this->setProtocol('https');

        $this->setAcceptFormat('JSON');
    }
}

class RamRoleArnService
{
    private $clientProfile;
    private $lastClearTime = null;
    private $sessionCredential = null;
    public static $serviceDomain = STS_DOMAIN;

    public function __construct($clientProfile)
    {
        $this->clientProfile = $clientProfile;
    }

    public function getSessionCredential()
    {
        if ($this->lastClearTime != null && $this->sessionCredential != null) {
            $now = time();
            $elapsedTime = $now - $this->lastClearTime;
            if ($elapsedTime <= ROLE_ARN_EXPIRE_TIME * 0.8) {
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
        $signer = $this->clientProfile->getSigner();
        $ramRoleArnCredential = $this->clientProfile->getCredential();

        $request = new AssumeRoleRequest($ramRoleArnCredential->getRoleArn(), $ramRoleArnCredential->getRoleSessionName());

        $requestUrl = $request->composeUrl($signer, $ramRoleArnCredential, self::$serviceDomain);

        $httpResponse = HttpHelper::curl($requestUrl, $request->getMethod(), null, $request->getHeaders());

        if (! $httpResponse->isSuccess()) {
            return null;
        }

        $respObj = json_decode($httpResponse->getBody());

        $sessionAccessKeyId = $respObj->Credentials->AccessKeyId;
        $sessionAccessKeySecret = $respObj->Credentials->AccessKeySecret;
        $securityToken = $respObj->Credentials->SecurityToken;

        return new Credential($sessionAccessKeyId, $sessionAccessKeySecret, $securityToken);
    }
}
