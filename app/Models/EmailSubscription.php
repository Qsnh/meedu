<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class EmailSubscription extends Model
{
    protected $table = 'email_subscriptions';

    protected $fillable = [
        'email',
    ];

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function saveFromRequest(Request $request)
    {
        $email = $request->post('email', '');
        if (! $email) {
            flash('请输入邮箱', 'warning');

            return back();
        }
        $exists = EmailSubscription::whereEmail($email)->exists();
        if (! $exists) {
            EmailSubscription::create(compact('email'));
        }
        flash('订阅成功', 'success');
    }
}
