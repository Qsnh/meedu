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

class SubmitSnapshotJobRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'SubmitSnapshotJob', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $resourceOwnerId;

    private $specifiedOffsetTime;

    private $resourceOwnerAccount;

    private $width;

    private $count;

    private $videoId;

    private $interval;

    private $ownerId;

    private $spriteSnapshotConfig;

    private $height;

    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    public function setResourceOwnerId($resourceOwnerId)
    {
        $this->resourceOwnerId = $resourceOwnerId;
        $this->queryParameters['ResourceOwnerId'] = $resourceOwnerId;
    }

    public function getSpecifiedOffsetTime()
    {
        return $this->specifiedOffsetTime;
    }

    public function setSpecifiedOffsetTime($specifiedOffsetTime)
    {
        $this->specifiedOffsetTime = $specifiedOffsetTime;
        $this->queryParameters['SpecifiedOffsetTime'] = $specifiedOffsetTime;
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

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
        $this->queryParameters['Width'] = $width;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = $count;
        $this->queryParameters['Count'] = $count;
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

    public function getInterval()
    {
        return $this->interval;
    }

    public function setInterval($interval)
    {
        $this->interval = $interval;
        $this->queryParameters['Interval'] = $interval;
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

    public function getSpriteSnapshotConfig()
    {
        return $this->spriteSnapshotConfig;
    }

    public function setSpriteSnapshotConfig($spriteSnapshotConfig)
    {
        $this->spriteSnapshotConfig = $spriteSnapshotConfig;
        $this->queryParameters['SpriteSnapshotConfig'] = $spriteSnapshotConfig;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
        $this->queryParameters['Height'] = $height;
    }
}
