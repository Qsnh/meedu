<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Member\Services;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ServiceException;
use App\Services\Member\Models\Socialite;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Interfaces\SocialiteServiceInterface;

class SocialiteService implements SocialiteServiceInterface
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param string $app
     * @param string $appId
     *
     * @return int
     */
    public function getBindUserId(string $app, string $appId): int
    {
        return Socialite::whereApp($app)->whereAppUserId($appId)->value('user_id');
    }

    /**
     * @param int    $userId
     * @param string $app
     * @param string $appId
     * @param array  $data
     *
     * @throws ServiceException
     */
    public function bindApp(int $userId, string $app, string $appId, array $data): void
    {
        $socialite = Socialite::whereUserId($userId)->whereApp($app)->first();
        if ($socialite) {
            throw new ServiceException(__('ban_bind_repeat'));
        }
        Socialite::create([
            'user_id' => $userId,
            'app' => $app,
            'app_user_id' => $appId,
            'data' => serialize($data),
        ]);
    }

    /**
     * @param string $app
     * @param string $appId
     * @param array  $data
     *
     * @return int
     */
    public function bindAppWithNewUser(string $app, string $appId, array $data): int
    {
        return DB::transaction(function () use ($app, $appId, $data) {
            $user = $this->userService->createWithoutMobile();
            Socialite::create([
                'user_id' => $user['id'],
                'app' => $app,
                'app_user_id' => $appId,
                'data' => serialize($data),
            ]);

            return $user['id'];
        });
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public function userSocialites(int $userId): array
    {
        return Socialite::whereUserId($userId)->get()->toArray();
    }
}
