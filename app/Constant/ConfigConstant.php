<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Constant;

class ConfigConstant
{

    public const PRIVATE_MASK = '************';

    public const WECHAT_PAY_CERT_CLIENT_KEY = 'pay.wechat.cert_client';
    public const WECHAT_PAY_CERT_KEY_KEY = 'pay.wechat.cert_key';
    public const WECHAT_PAY_CERT_CLIENT_PATH = 'private/wechat-pay-cert-client.pem';
    public const WECHAT_PAY_CERT_KEY_KEY_PATH = 'private/wechat-pay-cert-key.pem';

    public const ALIPAY_APP_CERT_PUBLIC_KEY_KEY = 'pay.alipay.app_cert_public_key';
    public const ALIPAY_ROOT_CERT_KEY = 'pay.alipay.alipay_root_cert';
    public const ALIPAY_APP_CERT_PUBLIC_KEY_PATH = 'private/alipay_app_cert_public_key.csr';
    public const ALIPAY_ROOT_CERT_PATH = 'private/alipay_root_cert.csr';
}
