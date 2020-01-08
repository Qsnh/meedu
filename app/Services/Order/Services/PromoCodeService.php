<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Order\Services;

use Illuminate\Support\Facades\Auth;
use App\Services\Order\Models\PromoCode;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;
use App\Services\Order\Interfaces\PromoCodeServiceInterface;

class PromoCodeService implements PromoCodeServiceInterface
{

    /**
     * @var ConfigService
     */
    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @param int $userId
     * @param string $code
     * @param string $expiredAt
     * @param int $reward1
     * @param int $reward2
     */
    public function create(int $userId, string $code, string $expiredAt, int $reward1, int $reward2): void
    {
        PromoCode::create([
            'user_id' => $userId,
            'code' => $code,
            'expired_at' => $expiredAt,
            'invite_user_reward' => $reward1,
            'invited_user_reward' => $reward2,
        ]);
    }

    /**
     * @param array $user
     */
    public function userCreate(array $user): void
    {
        $inviteConfig = $this->configService->getMemberInviteConfig();
        $data = [
            'user_id' => $user['id'],
            'code' => 'U' . $user['id'],
            'invite_user_reward' => $inviteConfig['invite_user_reward'],
            'invited_user_reward' => $inviteConfig['invited_user_reward'],
        ];
        PromoCode::create($data);
    }

    /**
     * @return array
     */
    public function userPromoCode(): array
    {
        $code = PromoCode::whereUserId(Auth::id())->first();
        return $code ? $code->toArray() : [];
    }

    /**
     * @param int $id
     * @return array
     */
    public function find(int $id): array
    {
        $code = PromoCode::find($id);
        return $code ? $code->toArray() : [];
    }
}
