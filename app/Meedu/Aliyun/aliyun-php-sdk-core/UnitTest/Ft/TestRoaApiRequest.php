<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UnitTest\Ft;

class TestRoaApiRequest extends \RoaAcsRequest
{
    public function __construct()
    {
        parent::__construct('Ft', '2016-01-02', 'TestRoaApi');
        $this->setUriPattern('/web/cloudapi');
        $this->setMethod('GET');
    }

    private $queryParam;

    private $bodyParam;

    private $headerParam;

    public function getQueryParam()
    {
        return $this->queryParam;
    }

    public function setQueryParam($queryParam)
    {
        $this->queryParam = $queryParam;
        $this->queryParameters['QueryParam'] = $queryParam;
    }

    public function getBodyParam()
    {
        return $this->bodyParam;
    }

    public function setBodyParam($bodyParam)
    {
        $this->bodyParam = $bodyParam;
        $this->queryParameters['BodyParam'] = $bodyParam;
    }

    public function getHeaderParam()
    {
        return $this->headerParam;
    }

    public function setHeaderParam($headerParam)
    {
        $this->headerParam = $headerParam;
        $this->headerParam['HeaderParam'] = $headerParam;
    }
}
