<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberRepository
{
    public $errors = '';

    /**
     * 会员密码修改逻辑.
     *
     * @param $oldPassword
     * @param $newPassword
     *
     * @return bool
     */
    public function passwordChangeHandler($oldPassword, $newPassword): bool
    {
        $user = Auth::user();
        if (! Hash::check($oldPassword, $user->password)) {
            $this->errors = '原密码不正确';

            return false;
        }
        $user->password = bcrypt($newPassword);
        $user->save();

        return true;
    }
}
