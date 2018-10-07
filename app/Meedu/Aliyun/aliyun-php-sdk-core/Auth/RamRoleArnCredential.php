<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class RamRoleArnCredential extends AbstractCredential
{
    private $accessKeyId;
    private $accessSecret;
    private $roleArn;
    private $roleSessionName;

    public function __construct($accessKeyId, $accessSecret, $roleArn, $roleSessionName)
    {
        $this->accessKeyId = $accessKeyId;
        $this->accessSecret = $accessSecret;
        $this->roleArn = $roleArn;
        $this->roleSessionName = $roleSessionName;
    }

    public function getAccessKeyId()
    {
        return $this->accessKeyId;
    }

    public function setAccessKeyId($accessKeyId)
    {
        $this->accessKeyId = $accessKeyId;
    }

    public function getAccessSecret()
    {
        return $this->accessSecret;
    }

    public function setAccessSecret($accessSecret)
    {
        $this->accessSecret = $accessSecret;
    }

    public function getRoleArn()
    {
        return $this->roleArn;
    }

    public function setRoleArn($roleArn)
    {
        $this->roleArn = $roleArn;
    }

    public function getRoleSessionName()
    {
        return $this->roleSessionName;
    }

    public function setRoleSessionName($roleSessionName)
    {
        $this->roleSessionName = $roleSessionName;
    }

    public function getSecurityToken()
    {
        return null;
    }
}
