<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

define("STS_PRODUCT_NAME", "Sts");
define("STS_DOMAIN", "sts.aliyuncs.com");
define("STS_VERSION", "2015-04-01");
define("STS_ACTION", "AssumeRole");
define("STS_REGION", "cn-hangzhou");
define("ROLE_ARN_EXPIRE_TIME", 3600);

class AssumeRoleRequest extends RpcAcsRequest
{
    function __construct($roleArn, $roleSessionName) {
        parent::__construct(STS_PRODUCT_NAME, STS_VERSION, STS_ACTION);

        $this->queryParameters["RoleArn"] = $roleArn;
        $this->queryParameters["RoleSessionName"] = $roleSessionName;
        $this->queryParameters["DurationSeconds"] = ROLE_ARN_EXPIRE_TIME;
        $this->setRegionId(ROLE_ARN_EXPIRE_TIME);
        $this->setProtocol("https");

        $this->setAcceptFormat("JSON");
    }
}

class RamRoleArnService
{
    private $clientProfile;
    private $lastClearTime = null;
    private $sessionCredential = null;
    public static $serviceDomain = STS_DOMAIN;

    function __construct($clientProfile) {
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

        if (!$httpResponse->isSuccess())
        {
            return null;
        }

        $respObj = json_decode($httpResponse->getBody());

        $sessionAccessKeyId = $respObj->Credentials->AccessKeyId;
        $sessionAccessKeySecret = $respObj->Credentials->AccessKeySecret;
        $securityToken = $respObj->Credentials->SecurityToken;
        return new Credential($sessionAccessKeyId, $sessionAccessKeySecret, $securityToken);
    }
}