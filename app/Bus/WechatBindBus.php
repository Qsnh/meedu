<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use Illuminate\Support\Str;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use App\Exceptions\ServiceException;
use App\Services\Member\Services\SocialiteService;
use App\Services\Member\Interfaces\SocialiteServiceInterface;

class WechatBindBus
{
    public const PREFIX = 'bind_';

    protected $bus;

    public function __construct(BusinessState $businessState)
    {
        $this->bus = $businessState;
    }

    public function isBind($code)
    {
        return Str::startsWith($code, self::PREFIX);
    }

    public function userId($code): int
    {
        $rows = explode('_', str_replace(self::PREFIX, '', $code));
        return (int)($rows[0] ?? 0);
    }

    public function qrcode(int $userId)
    {
        $code = $this->code($userId);
        $image = wechat_qrcode_image($code);
        return compact('code', 'image');
    }

    public function code(int $userId): string
    {
        return sprintf('%s%d_%s', self::PREFIX, $userId, Str::random(5));
    }

    public function handle(string $code, string $appId, array $userData = [])
    {
        $userId = $this->userId($code);
        if (!$userId) {
            throw new ServiceException(__('参数错误'));
        }

        $this->bus->socialiteBindCheck($userId, FrontendConstant::WECHAT_LOGIN_SIGN, $appId);

        /**
         * @var SocialiteService $socialiteService
         */
        $socialiteService = app()->make(SocialiteServiceInterface::class);

        $socialiteService->bindApp($userId, FrontendConstant::WECHAT_LOGIN_SIGN, $appId, $userData);
    }
}
