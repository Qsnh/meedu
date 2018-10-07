<?php
/**
 * Created by PhpStorm.
 * User: zhangw
 * Date: 2017/12/19
 * Time: 下午6:39
 */
namespace UnitTest\Ft;

class TestRpcApiRequest extends \RpcAcsRequest
{
    public function __construct()
    {
        parent::__construct("Ft", "2016-01-01", "TestRpcApi");
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
        $this->queryParameters["QueryParam"]=$queryParam;
    }

    public function getBodyParam()
    {
        return $this->bodyParam;
    }

    public function setBodyParam($bodyParam)
    {
        $this->bodyParam = $bodyParam;
        $this->queryParameters["BodyParam"]=$bodyParam;
    }
}