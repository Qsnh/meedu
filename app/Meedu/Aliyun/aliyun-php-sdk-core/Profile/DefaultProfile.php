<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

define("AUTH_TYPE_RAM_AK", "RAM_AK");
define("AUTH_TYPE_RAM_ROLE_ARN", "RAM_ROLE_ARN");
define("AUTH_TYPE_ECS_RAM_ROLE", "ECS_RAM_ROLE");

class DefaultProfile implements IClientProfile
{
	private static $profile;
	private static $endpoints;
	private static $credential;
	private static $regionId;
	private static $acceptFormat;
	private static $authType;
	
	private static $isigner;
	private static $iCredential;
	
	private function  __construct($regionId, $credential, $authType = AUTH_TYPE_RAM_AK)
	{
	    self::$regionId = $regionId;
	    self::$credential = $credential;
	    self::$authType = $authType;
	}
	
	public static function getProfile($regionId, $accessKeyId, $accessSecret, $securityToken = null)
	{
		$credential =new Credential($accessKeyId, $accessSecret, $securityToken);
		self::$profile = new DefaultProfile($regionId, $credential);
		return self::$profile;
	}

    public static function getRamRoleArnProfile($regionId, $accessKeyId, $accessSecret, $roleArn, $roleSessionName)
    {
        $credential =new RamRoleArnCredential($accessKeyId, $accessSecret, $roleArn, $roleSessionName);
        self::$profile = new DefaultProfile($regionId, $credential, AUTH_TYPE_RAM_ROLE_ARN);
        return self::$profile;
    }

    public static function getEcsRamRoleProfile($regionId, $roleName)
    {
        $credential =new EcsRamRoleCredential($roleName);
        self::$profile = new DefaultProfile($regionId, $credential, AUTH_TYPE_ECS_RAM_ROLE);
        return self::$profile;
    }
	
	public function getSigner()
	{
		if(null == self::$isigner)
		{
			self::$isigner = new ShaHmac1Signer(); 
		}
		return self::$isigner;
	}
	
	public function getRegionId()
	{
		return self::$regionId;
	}
	
	public function getFormat()
	{
		return self::$acceptFormat;
	}
	
	public function getCredential()
	{
		if(null == self::$credential && null != self::$iCredential)
		{
			self::$credential = self::$iCredential;
		}
		return self::$credential;
	}

    public function isRamRoleArn()
    {
        if(self::$authType == AUTH_TYPE_RAM_ROLE_ARN)
        {
            return true;
        }
        return false;
    }

    public function isEcsRamRole()
    {
        if(self::$authType == AUTH_TYPE_ECS_RAM_ROLE)
        {
            return true;
        }
        return false;
    }
	
	public static function getEndpoints()
	{
		if(null == self::$endpoints)
		{
			self::$endpoints = EndpointProvider::getEndpoints();
		}
		return self::$endpoints;
	}
	
	public static function addEndpoint($endpointName, $regionId, $product, $domain)
	{
		if(null == self::$endpoints)
		{
			self::$endpoints = self::getEndpoints();
		}
		$endpoint = self::findEndpointByName($endpointName);
		if(null == $endpoint)
		{
			self::addEndpoint_($endpointName, $regionId, $product, $domain);
		}
		else 
		{
			self::updateEndpoint($regionId, $product, $domain, $endpoint);
		}

		LocationService::addEndPoint($regionId, $product, $domain);
	}
	
	public static function findEndpointByName($endpointName)
	{
		foreach (self::$endpoints as $key => $endpoint)
		{
			if($endpoint->getName() == $endpointName)
			{
				return $endpoint;
			}
		}
	}
	
	private static function addEndpoint_($endpointName,$regionId, $product, $domain)
	{
		$regionIds = array($regionId);
		$productsDomains = array(new ProductDomain($product, $domain));
		$endpoint = new Endpoint($endpointName, $regionIds, $productsDomains);
		array_push(self::$endpoints, $endpoint);
	}
	
	private static function updateEndpoint($regionId, $product, $domain, $endpoint)
	{
		$regionIds = $endpoint->getRegionIds();
		if(!in_array($regionId,$regionIds))
		{
			array_push($regionIds, $regionId);
			$endpoint->setRegionIds($regionIds);
		}

        $productDomains = $endpoint->getProductDomains();
        if (null == self::findProductDomainAndUpdate($productDomains, $product, $domain)) {
            array_push($productDomains, new ProductDomain($product, $domain));
        }

        $endpoint->setProductDomains($productDomains);
    }
    
    private static function findProductDomainAndUpdate($productDomains, $product, $domain)
    {
        foreach ($productDomains as $key => $productDomain) {
            if ($productDomain->getProductName() == $product) {
                $productDomain->setDomainName($domain);
                return $productDomain;
            }
        }
        return null;
    }
}
