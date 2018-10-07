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

class GetAuditHistoryRequest extends \RpcAcsRequest
{
	function  __construct()
	{
		parent::__construct("vod", "2017-03-21", "GetAuditHistory", "vod", "openAPI");
		$this->setMethod("POST");
	}

	private  $pageNo;

	private  $pageSize;

	private  $videoId;

	private  $sortBy;

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

	public function getSortBy() {
		return $this->sortBy;
	}

	public function setSortBy($sortBy) {
		$this->sortBy = $sortBy;
		$this->queryParameters["SortBy"]=$sortBy;
	}
	
}