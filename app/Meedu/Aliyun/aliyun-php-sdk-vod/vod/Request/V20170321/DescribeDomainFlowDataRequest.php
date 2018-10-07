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

class DescribeDomainFlowDataRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'DescribeDomainFlowData', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $resourceOwnerId;

    private $resourceOwnerAccount;

    private $timeMerge;

    private $ownerAccount;

    private $domainName;

    private $endTime;

    private $locationNameEn;

    private $startTime;

    private $ispNameEn;

    private $ownerId;

    private $interval;

    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    public function setResourceOwnerId($resourceOwnerId)
    {
        $this->resourceOwnerId = $resourceOwnerId;
        $this->queryParameters['ResourceOwnerId'] = $resourceOwnerId;
    }

    public function getResourceOwnerAccount()
    {
        return $this->resourceOwnerAccount;
    }

    public function setResourceOwnerAccount($resourceOwnerAccount)
    {
        $this->resourceOwnerAccount = $resourceOwnerAccount;
        $this->queryParameters['ResourceOwnerAccount'] = $resourceOwnerAccount;
    }

    public function getTimeMerge()
    {
        return $this->timeMerge;
    }

    public function setTimeMerge($timeMerge)
    {
        $this->timeMerge = $timeMerge;
        $this->queryParameters['TimeMerge'] = $timeMerge;
    }

    public function getOwnerAccount()
    {
        return $this->ownerAccount;
    }

    public function setOwnerAccount($ownerAccount)
    {
        $this->ownerAccount = $ownerAccount;
        $this->queryParameters['OwnerAccount'] = $ownerAccount;
    }

    public function getDomainName()
    {
        return $this->domainName;
    }

    public function setDomainName($domainName)
    {
        $this->domainName = $domainName;
        $this->queryParameters['DomainName'] = $domainName;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
        $this->queryParameters['EndTime'] = $endTime;
    }

    public function getLocationNameEn()
    {
        return $this->locationNameEn;
    }

    public function setLocationNameEn($locationNameEn)
    {
        $this->locationNameEn = $locationNameEn;
        $this->queryParameters['LocationNameEn'] = $locationNameEn;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
        $this->queryParameters['StartTime'] = $startTime;
    }

    public function getIspNameEn()
    {
        return $this->ispNameEn;
    }

    public function setIspNameEn($ispNameEn)
    {
        $this->ispNameEn = $ispNameEn;
        $this->queryParameters['IspNameEn'] = $ispNameEn;
    }

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
        $this->queryParameters['OwnerId'] = $ownerId;
    }

    public function getInterval()
    {
        return $this->interval;
    }

    public function setInterval($interval)
    {
        $this->interval = $interval;
        $this->queryParameters['Interval'] = $interval;
    }
}
