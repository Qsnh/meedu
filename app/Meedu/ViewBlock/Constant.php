<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ViewBlock;

class Constant
{
    public const PLATFORM_PC = 'pc';
    public const PLATFORM_H5 = 'h5';

    // blocks
    public const H5_BLOCK_SIGN_VOD_V1 = 'h5-vod-v1';
    // PC点播
    public const PC_BLOCK_SIGN_VOD_V1 = 'pc-vod-v1';
    // 代码块
    public const PC_BLOCK_SIGN_CODE = 'code';
    // 辅助空白
    public const H5_BLOCK_BLANK = 'blank';
    // 图片魔方
    public const H5_BLOCK_IMAGE_GROUP = 'image-group';
    // 微信公众号
    public const H5_BLOCK_MP_WECHAT = 'mp-wechat';

    public const H5_BLOCK_SIGN_LIVE_V1 = 'h5-live-v1';

    public const H5_BLOCK_SIGN_BOOK_V1 = 'h5-book-v1';

    public const H5_BLOCK_SIGN_TOPIC_V1 = 'h5-topic-v1';

    public const H5_BLOCK_SIGN_LEARN_PATH_V1 = 'h5-learnPath-v1';

    public const H5_BLOCK_SIGN_MS_V1 = 'h5-ms-v1';

    public const H5_BLOCK_SIGN_TG_V1 = 'h5-tg-v1';

    public const H5_BLOCK_SIGN_SLIDER = 'slider';

    public const H5_BLOCK_SIGN_GRID_NAV = 'grid-nav';

    // pages
    public const H5_PAGE_INDEX_V1 = 'h5-page-index';

    public const PC_PAGE_INDEX = 'pc-page-index';

    public const PAGE_BLOCKS = [
        self::H5_PAGE_INDEX_V1 => [
            self::H5_BLOCK_SIGN_BOOK_V1,
            self::H5_BLOCK_SIGN_VOD_V1,
            self::H5_BLOCK_SIGN_LIVE_V1,
            self::H5_BLOCK_SIGN_TOPIC_V1,
            self::H5_BLOCK_SIGN_LEARN_PATH_V1,
            self::H5_BLOCK_SIGN_MS_V1,
            self::H5_BLOCK_SIGN_TG_V1,
        ],
    ];

    public const DATA_RENDER_BLOCK_WHITELIST = [
        self::H5_BLOCK_SIGN_GRID_NAV,
        self::H5_BLOCK_SIGN_SLIDER,
        self::PC_BLOCK_SIGN_CODE,
        self::H5_BLOCK_IMAGE_GROUP,
        self::H5_BLOCK_BLANK,
        self::H5_BLOCK_MP_WECHAT,
    ];
}
