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

class DeleteImageRequest extends \RpcAcsRequest
{
	function  __construct()
	{
		parent::__construct("vod", "2017-03-21", "DeleteImage", "vod", "openAPI");
		$this->setMethod("POST");
	}

	private  $resourceOwnerId;

	private  $imageType;

	private  $resourceOwnerAccount;

	private  $imageURLs;

	private  $videoId;

	private  $ownerId;

	private  $deleteImageType;

	private  $imageIds;

	public function getResourceOwnerId() {
		return $this->resourceOwnerId;
	}

	public function setResourceOwnerId($resourceOwnerId) {
		$this->resourceOwnerId = $resourceOwnerId;
		$this->queryParameters["ResourceOwnerId"]=$resourceOwnerId;
	}

	public function getImageType() {
		return $this->imageType;
	}

	public function setImageType($imageType) {
		$this->imageType = $imageType;
		$this->queryParameters["ImageType"]=$imageType;
	}

	public function getResourceOwnerAccount() {
		return $this->resourceOwnerAccount;
	}

	public function setResourceOwnerAccount($resourceOwnerAccount) {
		$this->resourceOwnerAccount = $resourceOwnerAccount;
		$this->queryParameters["ResourceOwnerAccount"]=$resourceOwnerAccount;
	}

	public function getImageURLs() {
		return $this->imageURLs;
	}

	public function setImageURLs($imageURLs) {
		$this->imageURLs = $imageURLs;
		$this->queryParameters["ImageURLs"]=$imageURLs;
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

	public function getDeleteImageType() {
		return $this->deleteImageType;
	}

	public function setDeleteImageType($deleteImageType) {
		$this->deleteImageType = $deleteImageType;
		$this->queryParameters["DeleteImageType"]=$deleteImageType;
	}

	public function getImageIds() {
		return $this->imageIds;
	}

	public function setImageIds($imageIds) {
		$this->imageIds = $imageIds;
		$this->queryParameters["ImageIds"]=$imageIds;
	}
	
}