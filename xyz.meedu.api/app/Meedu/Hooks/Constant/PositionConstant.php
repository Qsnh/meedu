<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Hooks\Constant;

class PositionConstant
{

    // 收到微信公众号消息
    public const MP_WECHAT_RECEIVER_MESSAGE = 'mp_wechat_receive_message';

    // ViewBlock钩子
    public const VIEW_BLOCK_DATA_RENDER = 'view_block_data_render';

    public const SYSTEM_APP_CONFIG_SYNC_WHITELIST = 'system_app_config_sync_whitelist';

    public const ORDER_STORE_INFO_PARSE = 'order_store_info_parse';
}
