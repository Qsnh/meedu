<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Services\Base\Model\AppConfig;
use App\Models\AdministratorPermission;

class UpgradeV480
{
    public static function handle()
    {
        self::deleteConfig();
        self::deletePermissions();
    }

    public static function deleteConfig()
    {
        AppConfig::query()
            ->whereIn('key', [
                'meedu.member.invite.free_user_enabled',
                'meedu.member.invite.invite_user_reward',
                'meedu.member.invite.invited_user_reward',
                'meedu.member.invite.effective_days',
                'meedu.member.invite.per_order_draw',
                'meedu.member.credit1.invite',//邀请送积分

                //微信小程序相关配置
                'pay.wechat.miniapp_id',
                'tencent.wechat.mini.app_id',
                'tencent.wechat.mini.secret',
            ])
            ->delete();
    }

    public static function deletePermissions()
    {
        AdministratorPermission::query()
            ->whereIn('slug', [
                'link.edit',//[link.update]
                'slider.edit',//[slider.update]
                'announcement.edit',//[announcement.update]
                'nav.create',//[nav.store]
                'nav.edit',//[nav.update]
                'role.edit',//[role.update]
                'administrator.create',//[administrator.store]
                'administrator.edit',//[administrator.update]
                'administrator.password',
                'administrator_role.create',//[administrator_role.store]
                'course.create',//[course.store]
                'course.edit',//[course.update]
                'course.user.watch.records',//[course.watchRecords]
                'course.subscribe.import',//[course.subscribe.create]
                'video.create',//[video.store]
                'video.edit',//[video.update]
                'video.destroy.multi',//[video.destroy]
                'video.import',//[video.store]
                'member.create',//[member.store]
                'member.edit',//[member.update]
                'member.update.field.multi',//[member.update]
                'member.message.send.multi',//[member.message.send]
                'member.import',//[member.store]
                'courseCategory.create',//[courseCategory.store]
                'courseCategory.edit',//[courseCategory.update]
                'member.tag.edit',//[member.tag.update]
                'promoCode.import',//[promoCode.store]
                'promoCode.edit',//[promoCode.update]
                'mpWechatMessageReply.create',//[mpWechatMessageReply.store]
                'mpWechatMessageReply.edit',//[mpWechatMessageReply.update]
                'viewBlock.edit',//[viewBlock.update]
                'video.token.tencent',//[video.upload.tencent.token]
                'video.token.aliyun.create',//[video.upload.aliyun.token]
                'video.token.aliyun.refresh',//[video.upload.aliyun.token]

                'member.detail.userInvite',
                'member.inviteBalance.withdrawOrders',
                'member.inviteBalance.withdrawOrders',

                'ad_from',
                'ad_from.store',
                'ad_from.edit',
                'ad_from.number',
                'ad_from.update',
                'ad_from.destroy',
            ])
            ->delete();
    }
}
