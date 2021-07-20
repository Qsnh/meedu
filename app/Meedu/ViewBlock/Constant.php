<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ViewBlock;

class Constant
{

    // blocks
    public const H5_BLOCK_SIGN_VOD_V1 = 'h5-vod-v1';
    public const PC_BLOCK_SIGN_VOD_V1 = 'pc-vod-v1';
    public const PC_BLOCK_SIGN_CODE = 'code';

    public const H5_BLOCK_SIGN_LIVE_V1 = 'h5-live-v1';

    public const H5_BLOCK_SIGN_BOOK_V1 = 'h5-book-v1';

    public const H5_BLOCK_SIGN_TOPIC_V1 = 'h5-topic-v1';

    public const H5_BLOCK_SIGN_LEARN_PATH_V1 = 'h5-learnPath-v1';

    public const H5_BLOCK_SIGN_MS_V1 = 'h5-ms-v1';

    public const H5_BLOCK_SIGN_TG_V1 = 'h5-tg-v1';

    public const H5_BLOCK_SIGN_SLIDER = 'slider';

    public const H5_BLOCK_SIGN_GRID_NAV = 'grid-nav';

    // pages
    public const H5_PAGE_INDEX_V1 = 'h5-page-index-v1';

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
        self::H5_BLOCK_SIGN_GRID_NAV,
        self::PC_BLOCK_SIGN_CODE,
    ];
}
