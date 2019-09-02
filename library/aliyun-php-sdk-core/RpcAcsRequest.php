<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

abstract class RpcAcsRequest extends AcsRequest
{
    private $dateTimeFormat = 'Y-m-d\TH:i:s\Z';
    private $domainParameters = [];

    public function __construct($product, $version, $actionName, $locationServiceCode = null, $locationEndpointType = 'openAPI')
    {
        parent::__construct($product, $version, $actionName, $locationServiceCode, $locationEndpointType);
        $this->initialize();
    }

    private function initialize()
    {
        $this->setMethod('GET');
        $this->setAcceptFormat('JSON');
    }

    private function prepareValue($value)
    {
        if (is_bool($value)) {
            if ($value) {
                return 'true';
            }

            return 'false';
        }

        return $value;
    }

    public function composeUrl($iSigner, $credential, $domain)
    {
        $apiParams = parent::getQueryParameters();
        foreach ($apiParams as $key => $value) {
            $apiParams[$key] = $this->prepareValue($value);
        }
        $apiParams['RegionId'] = $this->getRegionId();
        $apiParams['AccessKeyId'] = $credential->getAccessKeyId();
        $apiParams['Format'] = $this->getAcceptFormat();
        $apiParams['SignatureMethod'] = $iSigner->getSignatureMethod();
        $apiParams['SignatureVersion'] = $iSigner->getSignatureVersion();
        $apiParams['SignatureNonce'] = md5(uniqid(mt_rand(), true));
        $apiParams['Timestamp'] = gmdate($this->dateTimeFormat);
        $apiParams['Action'] = $this->getActionName();
        $apiParams['Version'] = $this->getVersion();
        if ($credential->getSecurityToken() != null) {
            $apiParams['SecurityToken'] = $credential->getSecurityToken();
        }
        $apiParams['Signature'] = $this->computeSignature($apiParams, $credential->getAccessSecret(), $iSigner);
        if (parent::getMethod() == 'POST') {
            $requestUrl = $this->getProtocol().'://'.$domain.'/';
            foreach ($apiParams as $apiParamKey => $apiParamValue) {
                $this->putDomainParameters($apiParamKey, $apiParamValue);
            }

            return $requestUrl;
        }
        $requestUrl = $this->getProtocol().'://'.$domain.'/?';

        foreach ($apiParams as $apiParamKey => $apiParamValue) {
            $requestUrl .= "$apiParamKey=".urlencode($apiParamValue).'&';
        }

        return substr($requestUrl, 0, -1);
    }

    private function computeSignature($parameters, $accessKeySecret, $iSigner)
    {
        ksort($parameters);
        $canonicalizedQueryString = '';
        foreach ($parameters as $key => $value) {
            $canonicalizedQueryString .= '&'.$this->percentEncode($key).'='.$this->percentEncode($value);
        }
        $stringToSign = parent::getMethod().'&%2F&'.$this->percentencode(substr($canonicalizedQueryString, 1));
        $signature = $iSigner->signString($stringToSign, $accessKeySecret.'&');

        return $signature;
    }

    protected function percentEncode($str)
    {
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);

        return $res;
    }

    public function getDomainParameter()
    {
        return $this->domainParameters;
    }

    public function putDomainParameters($name, $value)
    {
        $this->domainParameters[$name] = $value;
    }
}
