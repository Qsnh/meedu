<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
namespace vod\Request\V20170321;

class GetVideoPlayInfoRequest extends \RpcAcsRequest
{
	function  __construct()
	{
		parent::__construct("vod", "2017-03-21", "GetVideoPlayInfo", "vod", "openAPI");
		$this->setMethod("POST");
	}

	private  $signVersion;

	private  $resourceOwnerId;

	private  $clientVersion;

	private  $resourceOwnerAccount;

	private  $channel;

	private  $playSign;

	private  $videoId;

	private  $ownerId;

	private  $clientTS;

	public function getSignVersion() {
		return $this->signVersion;
	}

	public function setSignVersion($signVersion) {
		$this->signVersion = $signVersion;
		$this->queryParameters["SignVersion"]=$signVersion;
	}

	public function getResourceOwnerId() {
		return $this->resourceOwnerId;
	}

	public function setResourceOwnerId($resourceOwnerId) {
		$this->resourceOwnerId = $resourceOwnerId;
		$this->queryParameters["ResourceOwnerId"]=$resourceOwnerId;
	}

	public function getClientVersion() {
		return $this->clientVersion;
	}

	public function setClientVersion($clientVersion) {
		$this->clientVersion = $clientVersion;
		$this->queryParameters["ClientVersion"]=$clientVersion;
	}

	public function getResourceOwnerAccount() {
		return $this->resourceOwnerAccount;
	}

	public function setResourceOwnerAccount($resourceOwnerAccount) {
		$this->resourceOwnerAccount = $resourceOwnerAccount;
		$this->queryParameters["ResourceOwnerAccount"]=$resourceOwnerAccount;
	}

	public function getChannel() {
		return $this->channel;
	}

	public function setChannel($channel) {
		$this->channel = $channel;
		$this->queryParameters["Channel"]=$channel;
	}

	public function getPlaySign() {
		return $this->playSign;
	}

	public function setPlaySign($playSign) {
		$this->playSign = $playSign;
		$this->queryParameters["PlaySign"]=$playSign;
	}

	public function getVideoId() {
		return $this->videoId;
	}

	public function setVideoId($videoId) {
		$this->videoId = $videoId;
		$this->queryParameters["VideoId"]=$videoId;
	}

	public function getOwnerId() {
		return $this->ownerId;
	}

	public function setOwnerId($ownerId) {
		$this->ownerId = $ownerId;
		$this->queryParameters["OwnerId"]=$ownerId;
	}

	public function getClientTS() {
		return $this->clientTS;
	}

	public function setClientTS($clientTS) {
		$this->clientTS = $clientTS;
		$this->queryParameters["ClientTS"]=$clientTS;
	}
	
}