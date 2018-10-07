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

class UploadMediaByURLRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'UploadMediaByURL', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $resourceOwnerId;

    private $templateGroupId;

    private $uploadMetadatas;

    private $resourceOwnerAccount;

    private $uploadURLs;

    private $messageCallback;

    private $ownerId;

    private $priority;

    private $storageLocation;

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

    public function getUploadMetadatas()
    {
        return $this->uploadMetadatas;
    }

    public function setUploadMetadatas($uploadMetadatas)
    {
        $this->uploadMetadatas = $uploadMetadatas;
        $this->queryParameters['UploadMetadatas'] = $uploadMetadatas;
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

    public function getUploadURLs()
    {
        return $this->uploadURLs;
    }

    public function setUploadURLs($uploadURLs)
    {
        $this->uploadURLs = $uploadURLs;
        $this->queryParameters['UploadURLs'] = $uploadURLs;
    }

    public function getMessageCallback()
    {
        return $this->messageCallback;
    }

    public function setMessageCallback($messageCallback)
    {
        $this->messageCallback = $messageCallback;
        $this->queryParameters['MessageCallback'] = $messageCallback;
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

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
        $this->queryParameters['Priority'] = $priority;
    }

    public function getStorageLocation()
    {
        return $this->storageLocation;
    }

    public function setStorageLocation($storageLocation)
    {
        $this->storageLocation = $storageLocation;
        $this->queryParameters['StorageLocation'] = $storageLocation;
    }
}
