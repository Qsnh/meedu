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

class DescribePlayTopVideosRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('vod', '2017-03-21', 'DescribePlayTopVideos', 'vod', 'openAPI');
        $this->setMethod('POST');
    }

    private $bizDate;

    private $pageNo;

    private $pageSize;

    private $ownerId;

    public function getBizDate()
    {
        return $this->bizDate;
    }

    public function setBizDate($bizDate)
    {
        $this->bizDate = $bizDate;
        $this->queryParameters['BizDate'] = $bizDate;
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

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        $this->queryParameters['PageSize'] = $pageSize;
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
}
