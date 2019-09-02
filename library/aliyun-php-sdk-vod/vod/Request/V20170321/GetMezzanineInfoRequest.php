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

class GetMezzanineInfoRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'GetMezzanineInfo', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $resourceOwnerId;

    private $resourceOwnerAccount;

    private $videoId;

    private $previewSegment;

    private $outputType;

    private $additionType;

    private $ownerId;

    private $authTimeout;

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

    public function getVideoId()
    {
        return $this->videoId;
    }

    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
        $this->queryParameters['VideoId'] = $videoId;
    }

    public function getPreviewSegment()
    {
        return $this->previewSegment;
    }

    public function setPreviewSegment($previewSegment)
    {
        $this->previewSegment = $previewSegment;
        $this->queryParameters['PreviewSegment'] = $previewSegment;
    }

    public function getOutputType()
    {
        return $this->outputType;
    }

    public function setOutputType($outputType)
    {
        $this->outputType = $outputType;
        $this->queryParameters['OutputType'] = $outputType;
    }

    public function getAdditionType()
    {
        return $this->additionType;
    }

    public function setAdditionType($additionType)
    {
        $this->additionType = $additionType;
        $this->queryParameters['AdditionType'] = $additionType;
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

    public function getAuthTimeout()
    {
        return $this->authTimeout;
    }

    public function setAuthTimeout($authTimeout)
    {
        $this->authTimeout = $authTimeout;
        $this->queryParameters['AuthTimeout'] = $authTimeout;
    }
}
