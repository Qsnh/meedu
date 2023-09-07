<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\\QQ\\QqExtendSocialite@handle',
        ],
        // 支付成功event
        'App\Events\PaymentSuccessEvent' => [
            '\App\Listeners\PaymentSuccessEvent\OrderPaidDeliverListener',
            '\App\Listeners\PaymentSuccessEvent\OrderPaidNotificationListener',
            '\App\Listeners\PaymentSuccessEvent\OrderPaidStatusChangeListener',
            '\App\Listeners\PaymentSuccessEvent\Credit1RewardListener',
        ],
        // 订单取消
        'App\Events\OrderCancelEvent' => [
            '\App\Listeners\OrderCancelEvent\PromoCodeResumeListener',
        ],
        // 用户注册
        'App\Events\UserRegisterEvent' => [
            'App\Listeners\UserRegisterEvent\WelcomeMessageListener',
            'App\Listeners\UserRegisterEvent\RegisterIpRecordListener',
            'App\Listeners\UserRegisterEvent\RegisterCredit1RewardListener',
            'App\Listeners\UserRegisterEvent\RegisterSendVipListener',
        ],
        // 用户登录
        'App\Events\UserLoginEvent' => [
            'App\Listeners\UserLoginEvent\LoginRecordListener',
            'App\Listeners\UserLoginEvent\UserDeleteCancelListener',
        ],
        // 用户退出登录
        'App\Events\UserLogoutEvent' => [
            'App\Listeners\UserLogoutEvent\LoginRecordUpdateListener',
        ],
        // 用户看完视频
        'App\Events\UserVideoWatchedEvent' => [
            'App\Listeners\UserVideoWatchedEvent\UserVideoWatchedListener',
            'App\Listeners\UserVideoWatchedEvent\UserVideoWatchedCredit1RewardListener',
        ],
        // 用户看完录播课程
        'App\Events\UserCourseWatchedEvent' => [
            'App\Listeners\UserCourseWatchedEvent\UserCourseWatchedListener',
            'App\Listeners\UserCourseWatchedEvent\UserCourseWatchedCredit1RewardListener',
        ],
        // 系统配置变更
        'App\Events\AppConfigSavedEvent' => [
            'App\Listeners\AppConfigSavedEvent\WechatCertGenerateListener',
            'App\Listeners\AppConfigSavedEvent\AlipayCertGenerateListener',
        ],
        // 录播课程的增改删
        'App\Events\VodCourseCreatedEvent' => [
            'App\Listeners\VodCourseCreatedEvent\SearchRecordNotify',
        ],
        'App\Events\VodCourseUpdatedEvent' => [
            'App\Listeners\VodCourseUpdatedEvent\SearchRecordNotify',
        ],
        'App\Events\VodCourseDestroyedEvent' => [
            'App\Listeners\VodCourseDestroyedEvent\SearchRecordNotify',
        ],
        // 录播视频的增改删
        'App\Events\VodVideoCreatedEvent' => [
            'App\Listeners\VodVideoCreatedEvent\SearchRecordNotify',
        ],
        'App\Events\VodVideoUpdatedEvent' => [
            'App\Listeners\VodVideoUpdatedEvent\SearchRecordNotify',
        ],
        'App\Events\VodVideoDestroyedEvent' => [
            'App\Listeners\VodVideoDestroyedEvent\SearchRecordNotify',
            'App\Listeners\VodVideoDestroyedEvent\UserWatchedRecordClear',
        ],
        // 新视频上传event
        'App\Events\VideoUploadedEvent' => [],
        // 视频转码完成event
        'App\Events\VideoTranscodeCompleteEvent' => [],
        // 退款已申请
        'App\Events\OrderRefundCreated' => [],
        // 退款已处理[不一定成功]
        'App\Events\OrderRefundProcessed' => [
            'App\Listeners\OrderRefundProcessed\OrderRefundStatusChange',
            'App\Listeners\OrderRefundProcessed\UserNotify',
        ],
        // 用户删除提交事件
        'App\Events\UserDeleteSubmitEvent' => [],
        // 用户删除-取消事件
        'App\Events\UserDeleteCancelEvent' => [
            'App\Listeners\UserDeleteCancelEvent\UserNotify',
        ],
        // 用户已删除事件
        'App\Events\UserDeletedEvent' => [],
        // 用户实名认证通过事件
        'App\Events\UserVerifyFaceSuccessEvent' => [
            'App\Listeners\UserVerifyFaceSuccessEvent\UserNotifyListener',
            'App\Listeners\UserVerifyFaceSuccessEvent\UserProfileUpdateListener',
        ],
    ];
}
