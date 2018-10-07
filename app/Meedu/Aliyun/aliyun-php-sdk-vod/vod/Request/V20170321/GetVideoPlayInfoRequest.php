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

class GetVideoPlayInfoRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'GetVideoPlayInfo', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $signVersion;

    private $resourceOwnerId;

    private $clientVersion;

    private $resourceOwnerAccount;

    private $channel;

    private $playSign;

    private $videoId;

    private $ownerId;

    private $clientTS;

    public function getSignVersion()
    {
        return $this->signVersion;
    }

    public function setSignVersion($signVersion)
    {
        $this->signVersion = $signVersion;
        $this->queryParameters['SignVersion'] = $signVersion;
    }

    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    public function setResourceOwnerId($resourceOwnerId)
    {
        $this->resourceOwnerId = $resourceOwnerId;
        $this->queryParameters['ResourceOwnerId'] = $resourceOwnerId;
    }

    public function getClientVersion()
    {
        return $this->clientVersion;
    }

    public function setClientVersion($clientVersion)
    {
        $this->clientVersion = $clientVersion;
        $this->queryParameters['ClientVersion'] = $clientVersion;
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

    public function getChannel()
    {
        return $this->channel;
    }

    public function setChannel($channel)
    {
        $this->channel = $channel;
        $this->queryParameters['Channel'] = $channel;
    }

    public function getPlaySign()
    {
        return $this->playSign;
    }

    public function setPlaySign($playSign)
    {
        $this->playSign = $playSign;
        $this->queryParameters['PlaySign'] = $playSign;
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

    public function getClientTS()
    {
        return $this->clientTS;
    }

    public function setClientTS($clientTS)
    {
        $this->clientTS = $clientTS;
        $this->queryParameters['ClientTS'] = $clientTS;
    }
}
