<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * The current proxy header mappings.
     *
     * @var array
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR |
                            Request::HEADER_X_FORWARDED_HOST |
                            Request::HEADER_X_FORWARDED_PORT |
                            Request::HEADER_X_FORWARDED_PROTO |
                            Request::HEADER_X_FORWARDED_AWS_ELB;
}
