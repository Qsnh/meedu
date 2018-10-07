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

class SearchMediaRequest extends \RpcAcsRequest
{
	function  __construct()
	{
		parent::__construct("vod", "2017-03-21", "SearchMedia", "vod", "openAPI");
		$this->setMethod("POST");
	}

	private  $resourceOwnerId;

	private  $resourceOwnerAccount;

	private  $pageNo;

	private  $searchType;

	private  $match;

	private  $pageSize;

	private  $sortBy;

	private  $ownerId;

	private  $fields;

	private  $scrollToken;

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

	public function getPageNo() {
		return $this->pageNo;
	}

	public function setPageNo($pageNo) {
		$this->pageNo = $pageNo;
		$this->queryParameters["PageNo"]=$pageNo;
	}

	public function getSearchType() {
		return $this->searchType;
	}

	public function setSearchType($searchType) {
		$this->searchType = $searchType;
		$this->queryParameters["SearchType"]=$searchType;
	}

	public function getMatch() {
		return $this->match;
	}

	public function setMatch($match) {
		$this->match = $match;
		$this->queryParameters["Match"]=$match;
	}

	public function getPageSize() {
		return $this->pageSize;
	}

	public function setPageSize($pageSize) {
		$this->pageSize = $pageSize;
		$this->queryParameters["PageSize"]=$pageSize;
	}

	public function getSortBy() {
		return $this->sortBy;
	}

	public function setSortBy($sortBy) {
		$this->sortBy = $sortBy;
		$this->queryParameters["SortBy"]=$sortBy;
	}

	public function getOwnerId() {
		return $this->ownerId;
	}

	public function setOwnerId($ownerId) {
		$this->ownerId = $ownerId;
		$this->queryParameters["OwnerId"]=$ownerId;
	}

	public function getFields() {
		return $this->fields;
	}

	public function setFields($fields) {
		$this->fields = $fields;
		$this->queryParameters["Fields"]=$fields;
	}

	public function getScrollToken() {
		return $this->scrollToken;
	}

	public function setScrollToken($scrollToken) {
		$this->scrollToken = $scrollToken;
		$this->queryParameters["ScrollToken"]=$scrollToken;
	}
	
}