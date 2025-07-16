<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Constant;

class AgreementConstant
{
    // 协议类型
    public const TYPE_USER_AGREEMENT = 'user_agreement';
    public const TYPE_PRIVACY_POLICY = 'privacy_policy';
    public const TYPE_VIP_SERVICE_AGREEMENT = 'vip_service_agreement';
    public const TYPE_PAID_CONTENT_PURCHASE_AGREEMENT = 'paid_content_purchase_agreement';

    public const TYPES = [
        self::TYPE_USER_AGREEMENT => '用户协议',
        self::TYPE_PRIVACY_POLICY => '隐私政策',
        self::TYPE_VIP_SERVICE_AGREEMENT => '会员服务协议',
        self::TYPE_PAID_CONTENT_PURCHASE_AGREEMENT => '付费内容购买协议',
    ];

    // 需要强制同意的协议类型（用于登录检查）
    public const REQUIRED_AGREEMENT_TYPES = [
        self::TYPE_USER_AGREEMENT,
        self::TYPE_PRIVACY_POLICY,
    ];
}
