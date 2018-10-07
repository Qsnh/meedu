<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace vod\Request\V20170321;

class SetAuditSecurityIpRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'SetAuditSecurityIp', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $operateMode;

    private $securityGroupName;

    private $ips;

    public function getOperateMode()
    {
        return $this->operateMode;
    }

    public function setOperateMode($operateMode)
    {
        $this->operateMode = $operateMode;
        $this->queryParameters['OperateMode'] = $operateMode;
    }

    public function getSecurityGroupName()
    {
        return $this->securityGroupName;
    }

    public function setSecurityGroupName($securityGroupName)
    {
        $this->securityGroupName = $securityGroupName;
        $this->queryParameters['SecurityGroupName'] = $securityGroupName;
    }

    public function getIps()
    {
        return $this->ips;
    }

    public function setIps($ips)
    {
        $this->ips = $ips;
        $this->queryParameters['Ips'] = $ips;
    }
}
