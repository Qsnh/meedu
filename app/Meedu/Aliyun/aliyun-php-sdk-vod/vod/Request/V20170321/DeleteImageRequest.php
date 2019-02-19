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

class DeleteImageRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'DeleteImage', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $resourceOwnerId;

    private $imageType;

    private $resourceOwnerAccount;

    private $imageURLs;

    private $videoId;

    private $ownerId;

    private $deleteImageType;

    private $imageIds;

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

    public function getResourceOwnerAccount()
    {
        return $this->resourceOwnerAccount;
    }

    public function setResourceOwnerAccount($resourceOwnerAccount)
    {
        $this->resourceOwnerAccount = $resourceOwnerAccount;
        $this->queryParameters['ResourceOwnerAccount'] = $resourceOwnerAccount;
    }

    public function getImageURLs()
    {
        return $this->imageURLs;
    }

    public function setImageURLs($imageURLs)
    {
        $this->imageURLs = $imageURLs;
        $this->queryParameters['ImageURLs'] = $imageURLs;
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

    public function getDeleteImageType()
    {
        return $this->deleteImageType;
    }

    public function setDeleteImageType($deleteImageType)
    {
        $this->deleteImageType = $deleteImageType;
        $this->queryParameters['DeleteImageType'] = $deleteImageType;
    }

    public function getImageIds()
    {
        return $this->imageIds;
    }

    public function setImageIds($imageIds)
    {
        $this->imageIds = $imageIds;
        $this->queryParameters['ImageIds'] = $imageIds;
    }
}
