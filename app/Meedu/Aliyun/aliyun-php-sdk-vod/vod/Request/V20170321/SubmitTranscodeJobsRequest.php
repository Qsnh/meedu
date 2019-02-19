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

class SubmitTranscodeJobsRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'SubmitTranscodeJobs', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $resourceOwnerId;

    private $templateGroupId;

    private $resourceOwnerAccount;

    private $videoId;

    private $ownerId;

    private $encryptConfig;

    private $pipelineId;

    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    public function setResourceOwnerId($resourceOwnerId)
    {
        $this->resourceOwnerId = $resourceOwnerId;
        $this->queryParameters['ResourceOwnerId'] = $resourceOwnerId;
    }

    public function getTemplateGroupId()
    {
        return $this->templateGroupId;
    }

    public function setTemplateGroupId($templateGroupId)
    {
        $this->templateGroupId = $templateGroupId;
        $this->queryParameters['TemplateGroupId'] = $templateGroupId;
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

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
        $this->queryParameters['OwnerId'] = $ownerId;
    }

    public function getEncryptConfig()
    {
        return $this->encryptConfig;
    }

    public function setEncryptConfig($encryptConfig)
    {
        $this->encryptConfig = $encryptConfig;
        $this->queryParameters['EncryptConfig'] = $encryptConfig;
    }

    public function getPipelineId()
    {
        return $this->pipelineId;
    }

    public function setPipelineId($pipelineId)
    {
        $this->pipelineId = $pipelineId;
        $this->queryParameters['PipelineId'] = $pipelineId;
    }
}
