<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

abstract class RoaAcsRequest extends AcsRequest
{
    protected $uriPattern;
    private $pathParameters = [];
    private $domainParameters = [];
    private $dateTimeFormat = "D, d M Y H:i:s \G\M\T";
    private static $headerSeparator = "\n";
    private static $querySeprator = '&';

    public function __construct($product, $version, $actionName, $locationServiceCode = null, $locationEndpointType = 'openAPI')
    {
        parent::__construct($product, $version, $actionName, $locationServiceCode, $locationEndpointType);
        $this->setVersion($version);
        $this->initialize();
    }

    private function initialize()
    {
        $this->setMethod('RAW');
        $this->setAcceptFormat('JSON');
    }

    public function composeUrl($iSigner, $credential, $domain)
    {
        $this->prepareHeader($iSigner);

        $signString = $this->getMethod().self::$headerSeparator;
        if (isset($this->headers['Accept'])) {
            $signString = $signString.$this->headers['Accept'];
        }
        $signString = $signString.self::$headerSeparator;

        if (isset($this->headers['Content-MD5'])) {
            $signString = $signString.$this->headers['Content-MD5'];
        }
        $signString = $signString.self::$headerSeparator;

        if (isset($this->headers['Content-Type'])) {
            $signString = $signString.$this->headers['Content-Type'];
        }
        $signString = $signString.self::$headerSeparator;

        if (isset($this->headers['Date'])) {
            $signString = $signString.$this->headers['Date'];
        }
        $signString = $signString.self::$headerSeparator;

        $uri = $this->replaceOccupiedParameters();
        $signString = $signString.$this->buildCanonicalHeaders();
        $queryString = $this->buildQueryString($uri);
        $signString .= $queryString;
        $this->headers['Authorization'] = 'acs '.$credential->getAccessKeyId().':'
                .$iSigner->signString($signString, $credential->getAccessSecret());
        $requestUrl = $this->getProtocol().'://'.$domain.$uri.$this->concatQueryString();

        return $requestUrl;
    }

    private function concatQueryString()
    {
        $sortMap = $this->queryParameters;
        if (null == $sortMap || count($sortMap) == 0) {
            return '';
        }
        $queryString = '';
        ksort($sortMap);
        foreach ($sortMap as $sortMapKey => $sortMapValue) {
            $queryString = $queryString.$sortMapKey;
            if (isset($sortMapValue)) {
                $queryString = $queryString.'='.urlencode($sortMapValue);
            }
            $queryString .= self::$querySeprator;
        }

        if (count($sortMap) > 0) {
            $queryString = substr($queryString, 0, strlen($queryString) - 1);
        }

        return '?'.$queryString;
    }

    private function prepareHeader($iSigner)
    {
        $this->headers['Date'] = gmdate($this->dateTimeFormat);
        if (null == $this->acceptFormat) {
            $this->acceptFormat = 'RAW';
        }
        $this->headers['Accept'] = $this->formatToAccept($this->getAcceptFormat());
        $this->headers['x-acs-signature-method'] = $iSigner->getSignatureMethod();
        $this->headers['x-acs-signature-version'] = $iSigner->getSignatureVersion();
        $this->headers['x-acs-region-id'] = $this->regionId;
        $content = $this->getContent();
        if ($content != null) {
            $this->headers['Content-MD5'] = base64_encode(md5($content, true));
        }

        $this->headers['Content-Type'] = 'application/json;charset=utf-8';
    }

    private function replaceOccupiedParameters()
    {
        $result = $this->uriPattern;
        foreach ($this->pathParameters as $pathParameterKey => $apiParameterValue) {
            $target = '['.$pathParameterKey.']';
            $result = str_replace($target, $apiParameterValue, $result);
        }

        return $result;
    }

    private function buildCanonicalHeaders()
    {
        $sortMap = [];
        foreach ($this->headers as $headerKey => $headerValue) {
            $key = strtolower($headerKey);
            if (strpos($key, 'x-acs-') === 0) {
                $sortMap[$key] = $headerValue;
            }
        }
        ksort($sortMap);
        $headerString = '';
        foreach ($sortMap as $sortMapKey => $sortMapValue) {
            $headerString = $headerString.$sortMapKey.':'.$sortMapValue.self::$headerSeparator;
        }

        return $headerString;
    }

    private function splitSubResource($uri)
    {
        $queIndex = strpos($uri, '?');
        $uriParts = [];
        if (null != $queIndex) {
            array_push($uriParts, substr($uri, 0, $queIndex));
            array_push($uriParts, substr($uri, $queIndex + 1));
        } else {
            array_push($uriParts, $uri);
        }

        return $uriParts;
    }

    private function buildQueryString($uri)
    {
        $uriParts = $this->splitSubResource($uri);
        $sortMap = $this->queryParameters;
        if (isset($uriParts[1])) {
            $sortMap[$uriParts[1]] = null;
        }
        $queryString = $uriParts[0];
        if (count($sortMap) > 0) {
            $queryString = $queryString.'?';
        }
        ksort($sortMap);
        foreach ($sortMap as $sortMapKey => $sortMapValue) {
            $queryString = $queryString.$sortMapKey;
            if (isset($sortMapValue)) {
                $queryString = $queryString.'='.$sortMapValue;
            }
            $queryString = $queryString.self::$querySeprator;
        }
        if (count($sortMap) > 0) {
            $queryString = substr($queryString, 0, strlen($queryString) - 1);
        }

        return $queryString;
    }

    private function formatToAccept($acceptFormat)
    {
        if ($acceptFormat == 'JSON') {
            return 'application/json';
        } elseif ($acceptFormat == 'XML') {
            return 'application/xml';
        }

        return 'application/octet-stream';
    }

    public function getPathParameters()
    {
        return $this->pathParameters;
    }

    public function putPathParameter($name, $value)
    {
        $this->pathParameters[$name] = $value;
    }

    public function getDomainParameter()
    {
        return $this->domainParameters;
    }

    public function putDomainParameters($name, $value)
    {
        $this->domainParameters[$name] = $value;
    }

    public function getUriPattern()
    {
        return $this->uriPattern;
    }

    public function setUriPattern($uriPattern)
    {
        return $this->uriPattern = $uriPattern;
    }

    public function setVersion($version)
    {
        $this->version = $version;
        $this->headers['x-acs-version'] = $version;
    }
}
