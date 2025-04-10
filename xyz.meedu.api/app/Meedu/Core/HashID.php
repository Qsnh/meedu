<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core;

use Hashids\Hashids;

class HashID
{

    private static $client;

    private function __construct()
    {
    }

    /**
     * @return Hashids
     */
    public static function getInstance()
    {
        if (!self::$client) {
            self::$client = new Hashids(config('jwt.secret'), 16);
        }
        return self::$client;
    }

    public static function encode(int $number): string
    {
        return self::getInstance()->encode($number);
    }

    public static function decode(string $hashId)
    {
        $decode = self::getInstance()->decode($hashId);
        if (!$decode) {
            return false;
        }
        return $decode[0];
    }

}
