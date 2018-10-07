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

class ProduceEditingProjectVideoRequest extends \RpcAcsRequest
{
	function  __construct()
	{
		parent::__construct("vod", "2017-03-21", "ProduceEditingProjectVideo", "vod", "openAPI");
		$this->setMethod("POST");
	}

	private  $resourceOwnerId;

	private  $mediaMetadata;

	private  $resourceOwnerAccount;

	private  $description;

	private  $ownerId;

	private  $title;

	private  $coverURL;

	private  $userData;

	private  $timeline;

	private  $produceConfig;

	private  $projectId;

	public function getResourceOwnerId() {
		return $this->resourceOwnerId;
	}

	public function setResourceOwnerId($resourceOwnerId) {
		$this->resourceOwnerId = $resourceOwnerId;
		$this->queryParameters["ResourceOwnerId"]=$resourceOwnerId;
	}

	public function getMediaMetadata() {
		return $this->mediaMetadata;
	}

	public function setMediaMetadata($mediaMetadata) {
		$this->mediaMetadata = $mediaMetadata;
		$this->queryParameters["MediaMetadata"]=$mediaMetadata;
	}

	public function getResourceOwnerAccount() {
		return $this->resourceOwnerAccount;
	}

	public function setResourceOwnerAccount($resourceOwnerAccount) {
		$this->resourceOwnerAccount = $resourceOwnerAccount;
		$this->queryParameters["ResourceOwnerAccount"]=$resourceOwnerAccount;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($description) {
		$this->description = $description;
		$this->queryParameters["Description"]=$description;
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

	public function getCoverURL() {
		return $this->coverURL;
	}

	public function setCoverURL($coverURL) {
		$this->coverURL = $coverURL;
		$this->queryParameters["CoverURL"]=$coverURL;
	}

	public function getUserData() {
		return $this->userData;
	}

	public function setUserData($userData) {
		$this->userData = $userData;
		$this->queryParameters["UserData"]=$userData;
	}

	public function getTimeline() {
		return $this->timeline;
	}

	public function setTimeline($timeline) {
		$this->timeline = $timeline;
		$this->queryParameters["Timeline"]=$timeline;
	}

	public function getProduceConfig() {
		return $this->produceConfig;
	}

	public function setProduceConfig($produceConfig) {
		$this->produceConfig = $produceConfig;
		$this->queryParameters["ProduceConfig"]=$produceConfig;
	}

	public function getProjectId() {
		return $this->projectId;
	}

	public function setProjectId($projectId) {
		$this->projectId = $projectId;
		$this->queryParameters["ProjectId"]=$projectId;
	}
	
}