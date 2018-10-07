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

class GetMezzanineInfoRequest extends \RpcAcsRequest
{
	function  __construct()
	{
		parent::__construct("vod", "2017-03-21", "GetMezzanineInfo", "vod", "openAPI");
		$this->setMethod("POST");
	}

	private  $resourceOwnerId;

	private  $resourceOwnerAccount;

	private  $videoId;

	private  $previewSegment;

	private  $outputType;

	private  $additionType;

	private  $ownerId;

	private  $authTimeout;

	public function getResourceOwnerId() {
		return $this->resourceOwnerId;
	}

	public function setResourceOwnerId($resourceOwnerId) {
		$this->resourceOwnerId = $resourceOwnerId;
		$this->queryParameters["ResourceOwnerId"]=$resourceOwnerId;
	}

	public function getResourceOwnerAccount() {
		return $this->resourceOwnerAccount;
	}

	public function setResourceOwnerAccount($resourceOwnerAccount) {
		$this->resourceOwnerAccount = $resourceOwnerAccount;
		$this->queryParameters["ResourceOwnerAccount"]=$resourceOwnerAccount;
	}

	public function getVideoId() {
		return $this->videoId;
	}

	public function setVideoId($videoId) {
		$this->videoId = $videoId;
		$this->queryParameters["VideoId"]=$videoId;
	}

	public function getPreviewSegment() {
		return $this->previewSegment;
	}

	public function setPreviewSegment($previewSegment) {
		$this->previewSegment = $previewSegment;
		$this->queryParameters["PreviewSegment"]=$previewSegment;
	}

	public function getOutputType() {
		return $this->outputType;
	}

	public function setOutputType($outputType) {
		$this->outputType = $outputType;
		$this->queryParameters["OutputType"]=$outputType;
	}

	public function getAdditionType() {
		return $this->additionType;
	}

	public function setAdditionType($additionType) {
		$this->additionType = $additionType;
		$this->queryParameters["AdditionType"]=$additionType;
	}

	public function getOwnerId() {
		return $this->ownerId;
	}

	public function setOwnerId($ownerId) {
		$this->ownerId = $ownerId;
		$this->queryParameters["OwnerId"]=$ownerId;
	}

	public function getAuthTimeout() {
		return $this->authTimeout;
	}

	public function setAuthTimeout($authTimeout) {
		$this->authTimeout = $authTimeout;
		$this->queryParameters["AuthTimeout"]=$authTimeout;
	}
	
}