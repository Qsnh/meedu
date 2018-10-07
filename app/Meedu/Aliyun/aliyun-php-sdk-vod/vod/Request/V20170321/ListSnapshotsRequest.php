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

class ListSnapshotsRequest extends \RpcAcsRequest
{
	function  __construct()
	{
		parent::__construct("vod", "2017-03-21", "ListSnapshots", "vod", "openAPI");
		$this->setMethod("POST");
	}

	private  $resourceOwnerId;

	private  $resourceOwnerAccount;

	private  $snapshotType;

	private  $pageNo;

	private  $pageSize;

	private  $videoId;

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

	public function getSnapshotType() {
		return $this->snapshotType;
	}

	public function setSnapshotType($snapshotType) {
		$this->snapshotType = $snapshotType;
		$this->queryParameters["SnapshotType"]=$snapshotType;
	}

	public function getPageNo() {
		return $this->pageNo;
	}

	public function setPageNo($pageNo) {
		$this->pageNo = $pageNo;
		$this->queryParameters["PageNo"]=$pageNo;
	}

	public function getPageSize() {
		return $this->pageSize;
	}

	public function setPageSize($pageSize) {
		$this->pageSize = $pageSize;
		$this->queryParameters["PageSize"]=$pageSize;
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

	public function getAuthTimeout() {
		return $this->authTimeout;
	}

	public function setAuthTimeout($authTimeout) {
		$this->authTimeout = $authTimeout;
		$this->queryParameters["AuthTimeout"]=$authTimeout;
	}
	
}