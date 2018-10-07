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

class SearchMediaRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'SearchMedia', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $resourceOwnerId;

    private $resourceOwnerAccount;

    private $pageNo;

    private $searchType;

    private $match;

    private $pageSize;

    private $sortBy;

    private $ownerId;

    private $fields;

    private $scrollToken;

    public function getResourceOwnerId()
    {
        return $this->resourceOwnerId;
    }

    public function setResourceOwnerId($resourceOwnerId)
    {
        $this->resourceOwnerId = $resourceOwnerId;
        $this->queryParameters['ResourceOwnerId'] = $resourceOwnerId;
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

    public function getPageNo()
    {
        return $this->pageNo;
    }

    public function setPageNo($pageNo)
    {
        $this->pageNo = $pageNo;
        $this->queryParameters['PageNo'] = $pageNo;
    }

    public function getSearchType()
    {
        return $this->searchType;
    }

    public function setSearchType($searchType)
    {
        $this->searchType = $searchType;
        $this->queryParameters['SearchType'] = $searchType;
    }

    public function getMatch()
    {
        return $this->match;
    }

    public function setMatch($match)
    {
        $this->match = $match;
        $this->queryParameters['Match'] = $match;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        $this->queryParameters['PageSize'] = $pageSize;
    }

    public function getSortBy()
    {
        return $this->sortBy;
    }

    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
        $this->queryParameters['SortBy'] = $sortBy;
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

    public function getFields()
    {
        return $this->fields;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
        $this->queryParameters['Fields'] = $fields;
    }

    public function getScrollToken()
    {
        return $this->scrollToken;
    }

    public function setScrollToken($scrollToken)
    {
        $this->scrollToken = $scrollToken;
        $this->queryParameters['ScrollToken'] = $scrollToken;
    }
}
