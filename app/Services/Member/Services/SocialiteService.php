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

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Auth;
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
        return (int)Socialite::whereApp($app)->whereAppUserId($appId)->value('user_id');
    }

    /**
     * @param int $userId
     * @param string $app
     * @param string $appId
     * @param array $data
     *
     * @throws ServiceException
     */
    public function bindApp(int $userId, string $app, string $appId, array $data): void
    {
        $socialite = Socialite::query()->where('app', $app)->where('app_user_id', $appId)->first();
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
     * @param array $data
     *
     * @return int
     */
    public function bindAppWithNewUser(string $app, string $appId, array $data): int
    {
        return DB::transaction(function () use ($app, $appId, $data) {
            $avatar = $data['avatar'] ?? '';
            $nickname = $data['nickname'] ?? '';
            $nickname && $nickname .= '_' . Str::random(3);
            $user = $this->userService->createWithoutMobile($avatar, $nickname);
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

    /**
     * @param string $app
     */
    public function cancelBind(string $app): void
    {
        $bindApps = Socialite::whereUserId(Auth::id())->get()->keyBy('app')->toArray();
        if (!isset($bindApps[$app])) {
            return;
        }
        Socialite::whereId($bindApps[$app]['id'])->delete();
    }
}
