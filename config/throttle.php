<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

return [
    'whitelist_ip' => explode(',', env('THROTTLE_WHITELIST_IP', '')),
];
