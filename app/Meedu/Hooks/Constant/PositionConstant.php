<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Hooks\Constant;

class PositionConstant
{

    // 收到微信公众号消息
    public const MP_WECHAT_RECEIVER_MESSAGE = 'mp_wechat_receive_message';

    // 会员中心视图钩子
    public const VIEW_MEMBER_INDEX_LEFT_MENUS = 'view_member_index_left_menus';

    // 首页视图钩子
    public const VIEW_INDEX_SECTION_1 = 'view_index_section_1';
    public const VIEW_INDEX_SECTION_2 = 'view_index_section_2';

    // ViewBlock钩子
    public const VIEW_BLOCK_DATA_RENDER = 'view_block_data_render';
    public const VIEW_BLOCK_HTML_RENDER = 'view_block_html_render';
}
