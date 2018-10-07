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

class CreateUploadImageRequest extends \RpcAcsRequest
{
	function  __construct()
	{
		parent::__construct("vod", "2017-03-21", "CreateUploadImage", "vod", "openAPI");
		$this->setMethod("POST");
	}

	private  $resourceOwnerId;

	private  $imageType;

	private  $originalFileName;

	private  $resourceOwnerAccount;

	private  $imageExt;

	private  $ownerId;

	private  $title;

	private  $tags;

	private  $storageLocation;

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

	public function getOriginalFileName() {
		return $this->originalFileName;
	}

	public function setOriginalFileName($originalFileName) {
		$this->originalFileName = $originalFileName;
		$this->queryParameters["OriginalFileName"]=$originalFileName;
	}

	public function getResourceOwnerAccount() {
		return $this->resourceOwnerAccount;
	}

	public function setResourceOwnerAccount($resourceOwnerAccount) {
		$this->resourceOwnerAccount = $resourceOwnerAccount;
		$this->queryParameters["ResourceOwnerAccount"]=$resourceOwnerAccount;
	}

	public function getImageExt() {
		return $this->imageExt;
	}

	public function setImageExt($imageExt) {
		$this->imageExt = $imageExt;
		$this->queryParameters["ImageExt"]=$imageExt;
	}

	public function getOwnerId() {
		return $this->ownerId;
	}

	public function setOwnerId($ownerId) {
		$this->ownerId = $ownerId;
		$this->queryParameters["OwnerId"]=$ownerId;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
		$this->queryParameters["Title"]=$title;
	}

	public function getTags() {
		return $this->tags;
	}

	public function setTags($tags) {
		$this->tags = $tags;
		$this->queryParameters["Tags"]=$tags;
	}

	public function getStorageLocation() {
		return $this->storageLocation;
	}

	public function setStorageLocation($storageLocation) {
		$this->storageLocation = $storageLocation;
		$this->queryParameters["StorageLocation"]=$storageLocation;
	}
	
}