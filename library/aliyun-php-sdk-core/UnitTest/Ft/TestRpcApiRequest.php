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

class TestRpcApiRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct('Ft', '2016-01-01', 'TestRpcApi');
    }

    private $queryParam;

    private $bodyParam;

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
}
