<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

define('LOCATION_SERVICE_PRODUCT_NAME', 'Location');
define('LOCATION_SERVICE_DOMAIN', 'location.aliyuncs.com');
define('LOCATION_SERVICE_VERSION', '2015-06-12');
define('LOCATION_SERVICE_DESCRIBE_ENDPOINT_ACTION', 'DescribeEndpoints');
define('LOCATION_SERVICE_REGION', 'cn-hangzhou');
define('CACHE_EXPIRE_TIME', 3600);

class DescribeEndpointRequest extends RpcAcsRequest
{
    public function __construct($id, $serviceCode, $endPointType)
    {
        parent::__construct(LOCATION_SERVICE_PRODUCT_NAME, LOCATION_SERVICE_VERSION, LOCATION_SERVICE_DESCRIBE_ENDPOINT_ACTION);

        $this->queryParameters['Id'] = $id;
        $this->queryParameters['ServiceCode'] = $serviceCode;
        $this->queryParameters['Type'] = $endPointType;
        $this->setRegionId(LOCATION_SERVICE_REGION);

        $this->setAcceptFormat('JSON');
    }
}

class LocationService
{
    private $clientProfile;
    public static $cache = [];
    public static $lastClearTimePerProduct = [];
    public static $serviceDomain = LOCATION_SERVICE_DOMAIN;

    public function __construct($clientProfile)
    {
        $this->clientProfile = $clientProfile;
    }

    public function findProductDomain($regionId, $serviceCode, $endPointType, $product)
    {
        $key = $regionId.'#'.$product;
        @$domain = self::$cache[$key];
        if ($domain == null || $this->checkCacheIsExpire($key) == true) {
            $domain = $this->findProductDomainFromLocationService($regionId, $serviceCode, $endPointType);
            self::$cache[$key] = $domain;
        }

        return $domain;
    }

    public static function addEndPoint($regionId, $product, $domain)
    {
        $key = $regionId.'#'.$product;
        self::$cache[$key] = $domain;
        $lastClearTime = mktime(0, 0, 0, 1, 1, 2999);
        self::$lastClearTimePerProduct[$key] = $lastClearTime;
    }

    public static function modifyServiceDomain($domain)
    {
        self::$serviceDomain = $domain;
    }

    private function checkCacheIsExpire($key)
    {
        $lastClearTime = self::$lastClearTimePerProduct[$key];
        if ($lastClearTime == null) {
            $lastClearTime = time();
            self::$lastClearTimePerProduct[$key] = $lastClearTime;
        }

        $now = time();
        $elapsedTime = $now - $lastClearTime;

        if ($elapsedTime > CACHE_EXPIRE_TIME) {
            $lastClearTime = time();
            self::$lastClearTimePerProduct[$key] = $lastClearTime;

            return true;
        }

        return false;
    }

    private function findProductDomainFromLocationService($regionId, $serviceCode, $endPointType)
    {
        $request = new DescribeEndpointRequest($regionId, $serviceCode, $endPointType);

        $signer = $this->clientProfile->getSigner();
        $credential = $this->clientProfile->getCredential();

        $requestUrl = $request->composeUrl($signer, $credential, self::$serviceDomain);

        $httpResponse = HttpHelper::curl($requestUrl, $request->getMethod(), null, $request->getHeaders());

        if (! $httpResponse->isSuccess()) {
            return null;
        }

        $respObj = json_decode($httpResponse->getBody());

        return $respObj->Endpoints->Endpoint[0]->Endpoint;
    }
}
