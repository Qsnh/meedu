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

class GetAuditHistoryRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'GetAuditHistory', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $pageNo;

    private $pageSize;

    private $videoId;

    private $sortBy;

    public function getPageNo()
    {
        return $this->pageNo;
    }

    public function setPageNo($pageNo)
    {
        $this->pageNo = $pageNo;
        $this->queryParameters['PageNo'] = $pageNo;
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

    public function getVideoId()
    {
        return $this->videoId;
    }

    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
        $this->queryParameters['VideoId'] = $videoId;
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
}
