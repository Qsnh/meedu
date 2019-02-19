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

class GetPlayInfoRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'GetPlayInfo', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $resourceOwnerId;

    private $streamType;

    private $formats;

    private $resourceOwnerAccount;

    private $channel;

    private $videoId;

    private $playerVersion;

    private $ownerId;

    private $resultType;

    private $rand;

    private $reAuthInfo;

    private $outputType;

    private $definition;

    private $authTimeout;

    private $authInfo;

    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    public function setResourceOwnerId($resourceOwnerId)
    {
        $this->resourceOwnerId = $resourceOwnerId;
        $this->queryParameters['ResourceOwnerId'] = $resourceOwnerId;
    }

    public function getStreamType()
    {
        return $this->streamType;
    }

    public function setStreamType($streamType)
    {
        $this->streamType = $streamType;
        $this->queryParameters['StreamType'] = $streamType;
    }

    public function getFormats()
    {
        return $this->formats;
    }

    public function setFormats($formats)
    {
        $this->formats = $formats;
        $this->queryParameters['Formats'] = $formats;
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

    public function getVideoId()
    {
        return $this->videoId;
    }

    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
        $this->queryParameters['VideoId'] = $videoId;
    }

    public function getPlayerVersion()
    {
        return $this->playerVersion;
    }

    public function setPlayerVersion($playerVersion)
    {
        $this->playerVersion = $playerVersion;
        $this->queryParameters['PlayerVersion'] = $playerVersion;
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

    public function getResultType()
    {
        return $this->resultType;
    }

    public function setResultType($resultType)
    {
        $this->resultType = $resultType;
        $this->queryParameters['ResultType'] = $resultType;
    }

    public function getRand()
    {
        return $this->rand;
    }

    public function setRand($rand)
    {
        $this->rand = $rand;
        $this->queryParameters['Rand'] = $rand;
    }

    public function getReAuthInfo()
    {
        return $this->reAuthInfo;
    }

    public function setReAuthInfo($reAuthInfo)
    {
        $this->reAuthInfo = $reAuthInfo;
        $this->queryParameters['ReAuthInfo'] = $reAuthInfo;
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

    public function getDefinition()
    {
        return $this->definition;
    }

    public function setDefinition($definition)
    {
        $this->definition = $definition;
        $this->queryParameters['Definition'] = $definition;
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

    public function getAuthInfo()
    {
        return $this->authInfo;
    }

    public function setAuthInfo($authInfo)
    {
        $this->authInfo = $authInfo;
        $this->queryParameters['AuthInfo'] = $authInfo;
    }
}
