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

class CreateUploadImageRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'CreateUploadImage', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $resourceOwnerId;

    private $imageType;

    private $originalFileName;

    private $resourceOwnerAccount;

    private $imageExt;

    private $ownerId;

    private $title;

    private $tags;

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

    public function getImageType()
    {
        return $this->imageType;
    }

    public function setImageType($imageType)
    {
        $this->imageType = $imageType;
        $this->queryParameters['ImageType'] = $imageType;
    }

    public function getOriginalFileName()
    {
        return $this->originalFileName;
    }

    public function setOriginalFileName($originalFileName)
    {
        $this->originalFileName = $originalFileName;
        $this->queryParameters['OriginalFileName'] = $originalFileName;
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

    public function getImageExt()
    {
        return $this->imageExt;
    }

    public function setImageExt($imageExt)
    {
        $this->imageExt = $imageExt;
        $this->queryParameters['ImageExt'] = $imageExt;
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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        $this->queryParameters['Title'] = $title;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
        $this->queryParameters['Tags'] = $tags;
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
