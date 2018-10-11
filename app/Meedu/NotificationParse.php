<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu;

class NotificationParse
{
    public function parseText($notification): string
    {
        $method = 'parse'.$this->getTypeName($notification).'Text';

        return $this->{$method}($notification);
    }

    public function parseHTML($notification): string
    {
        $method = 'parse'.$this->getTypeName($notification).'HTML';

        return $this->{$method}($notification);
    }

    protected function getTypeName($notification)
    {
        $type = $notification->type;
        $arr = explode('\\', $type);
        $name = $arr[count($arr) - 1];

        return $name;
    }

    protected function parseAtUserNotificationText($notification): string
    {
        $data = $notification->data;
        $fromUser = \App\User::find($data['from_user_id']);

        return sprintf('用户%s提到您啦', $fromUser->nick_name);
    }

    protected function parseAtUserNotificationHTML($notification): string
    {
        $data = $notification->data;
        $fromUser = \App\User::find($data['from_user_id']);
        $model = '\\App\\Models\\'.$data['from_type'];
        $from = (new $model())->whereId($data['from_id'])->first();
        $url = 'javascript:void(0)';
        switch ($data['from_type']) {
            case 'CourseComment':
                $url = route('course.show', [$from->course->id, $from->course->slug]);
                break;
            case 'VideoComment':
                $url = route('video.show', [$from->video->course->id, $from->video->id, $from->video->slug]);
                break;
        }

        return '<a href="'.$url.'">用户&nbsp;<b>'.$fromUser->nick_name.'</b>&nbsp;提到您啦。</a>';
    }

    public function parseMemberRechargeNotificationText($notification): string
    {
        return sprintf('您充值的%s已到账。', $notification->data['money']);
    }

    public function parseMemberRechargeNotificationHTML($notification): string
    {
        return sprintf('您充值的%s已到账。', $notification->data['money']);
    }

    public function parseRegisterNotificationText($notification): string
    {
        return '欢迎注册本站！';
    }

    public function parseRegisterNotificationHTML($notification): string
    {
        return '欢迎注册本站！';
    }

    public function parseSimpleMessageNotificationText($notification): string
    {
        return $notification->data['message'];
    }

    public function parseSimpleMessageNotificationHTML($notification): string
    {
        return $notification->data['message'];
    }
}
