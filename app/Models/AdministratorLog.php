<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AdministratorLog extends Model
{
    public const OPT_VIEW = 'VIEW';
    public const OPT_STORE = 'STORE';
    public const OPT_IMPORT = 'IMPORT';
    public const OPT_UPDATE = 'UPDATE';
    public const OPT_DESTROY = 'DESTROY';
    public const OPT_LOGIN = 'LOGIN';
    public const OPT_LOGOUT = 'LOGOUT';
    public const OPT_REFUND = 'REFUND';

    public const MODULE_VOD = 'vod';
    public const MODULE_VOD_VIDEO = 'vod-video';
    public const MODULE_VOD_VIDEO_COMMENT = 'vod-video-comment';
    public const MODULE_VOD_ATTACH = 'vod-attach';
    public const MODULE_VOD_CATEGORY = 'vod-category';
    public const MODULE_VOD_CHAPTER = 'vod-chapter';
    public const MODULE_VOD_COMMENT = 'vod-comment';

    public const MODULE_ADMIN_DASHBOARD = 'admin-dashboard';
    public const MODULE_ADMIN_LOGIN = 'admin-login';
    public const MODULE_ADMIN_MEDIA_IMAGE = 'admin-media-image';
    public const MODULE_ADMIN_MEDIA_VIDEO = 'admin-media-video';

    public const MODULE_SYSTEM_CONFIG = 'system-config';

    public const MODULE_STATS = 'stats';

    public const MODULE_MEMBER = 'member';
    public const MODULE_MEMBER_TAG = 'member-tag';

    public const MODULE_MP_MENU = 'mp-menu';
    public const MODULE_MP_MESSAGE = 'mp-message';

    public const MODULE_VIP = 'vip';
    public const MODULE_ADDONS = 'addons';
    public const MODULE_AD_FROM = 'ad-from';
    public const MODULE_LINK = 'link';
    public const MODULE_NAV = 'nav';
    public const MODULE_SLIDER = 'slider';
    public const MODULE_ORDER = 'order';
    public const MODULE_VIEW_BLOCK = 'view-block';
    public const MODULE_PROMO_CODE = 'promo-code';
    public const MODULE_ANNOUNCEMENT = 'announcement';

    public const MODULE_ADMINISTRATOR = 'administrator';
    public const MODULE_ADMINISTRATOR_ROLE = 'administrator-role';

    protected $table = 'administrator_logs';

    public $timestamps = false;

    protected $fillable = [
        'admin_id', 'module', 'opt', 'remark', 'created_at', 'ip'
    ];

    public static function storeLog(string $module, string $opt, $remark = ''): void
    {
        if (is_array($remark)) {
            if (!isset($remark['path'])) {//携带上当前请求的path
                $remark['path'] = request()->path();
            }
            $remark = json_encode($remark, JSON_UNESCAPED_UNICODE);
        }

        self::create([
            'admin_id' => Auth::guard('administrator')->id(),
            'module' => $module,
            'opt' => $opt,
            'remark' => $remark,
            'created_at' => Carbon::now()->toDateTimeLocalString(),
            'ip' => request()->getClientIp() ?? '',
        ]);
    }

    public static function storeLogDiff(string $module, string $opt, array $newData, array $oldData, array $extra = []): void
    {
        $diff = [];
        $remark = '';
        foreach ($newData as $key => $newVal) {
            // 新值
            $newValCompare = $newVal;
            if (is_array($newValCompare)) {
                $newValCompare = json_encode($newValCompare, JSON_UNESCAPED_UNICODE);
            }

            // 旧值
            $oldValCompare = $oldData[$key] ?? null;
            if (is_array($oldValCompare)) {
                $oldValCompare = json_encode($oldValCompare, JSON_UNESCAPED_UNICODE);
            }

            if ($newValCompare !== $oldValCompare) {//直接比较
                $diff[] = sprintf("%s\nfrom:\n%s\nto:\n%s", $key, $oldValCompare, $newValCompare);
            }
        }
        $extra && $diff[] = json_encode($extra, JSON_UNESCAPED_UNICODE);

        $diff && $remark = implode("\n\n=============\n\n", $diff);
        self::storeLog($module, $opt, $remark);
    }
}
