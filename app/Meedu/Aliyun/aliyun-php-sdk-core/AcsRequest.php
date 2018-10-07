<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

abstract class AcsRequest
{
    protected $version;
    protected $product;
    protected $actionName;
    protected $regionId;
    protected $acceptFormat;
    protected $method;
    protected $protocolType = 'http';
    protected $content;

    protected $queryParameters = [];
    protected $headers = [];

    protected $locationServiceCode;
    protected $locationEndpointType;

    public function __construct($product, $version, $actionName, $locationServiceCode = null, $locationEndpointType = 'openAPI')
    {
        $this->headers['x-sdk-client'] = 'php/2.0.0';
        $this->product = $product;
        $this->version = $version;
        $this->actionName = $actionName;

        $this->locationServiceCode = $locationServiceCode;
        $this->locationEndpointType = $locationEndpointType;
    }

    abstract public function composeUrl($iSigner, $credential, $domain);

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        $this->product = $product;
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    public function setActionName($actionName)
    {
        $this->actionName = $actionName;
    }

    public function getAcceptFormat()
    {
        return	$this->acceptFormat;
    }

    public function setAcceptFormat($acceptFormat)
    {
        $this->acceptFormat = $acceptFormat;
    }

    public function getQueryParameters()
    {
        return $this->queryParameters;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getProtocol()
    {
        return $this->protocolType;
    }

    public function setProtocol($protocol)
    {
        $this->protocolType = $protocol;
    }

    public function getRegionId()
    {
        return $this->regionId;
    }

    public function setRegionId($region)
    {
        $this->regionId = $region;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function addHeader($headerKey, $headerValue)
    {
        $this->headers[$headerKey] = $headerValue;
    }

    public function getLocationServiceCode()
    {
        return $this->locationServiceCode;
    }

    public function getLocationEndpointType()
    {
        return $this->locationEndpointType;
    }
}
