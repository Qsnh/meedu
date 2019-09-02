<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UnitTest\BatchCompute\Request;

class ListImagesRequest extends \RoaAcsRequest
{
    public function __construct()
    {
        parent::__construct('BatchCompute', '2013-01-11', 'ListImages');
        $this->setUriPattern('/images');
        $this->setMethod('GET');
    }
}
