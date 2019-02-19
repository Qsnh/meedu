<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

class EcsRamRoleCredential extends AbstractCredential
{
    private $roleName;

    public function __construct($roleName)
    {
        $this->roleName = $roleName;
    }

    public function getAccessKeyId()
    {
        return null;
    }

    public function getAccessSecret()
    {
        return null;
    }

    public function getRoleName()
    {
        return $this->roleName;
    }

    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;
    }

    public function getSecurityToken()
    {
        return null;
    }
}
