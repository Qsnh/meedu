<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Member\Services;

use Illuminate\Support\Str;
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
     * @return array
     */
    public function findBind(string $app, string $appId): array
    {
        $record = Socialite::query()
            ->where('app', $app)
            ->where('app_user_id', $appId)
            ->first();

        return $record ? $record->toArray() : [];
    }

    /**
     * @param string $app
     * @param string $appId
     *
     * @return int
     */
    public function getBindUserId(string $app, string $appId): int
    {
        return (int)Socialite::query()
            ->where('app', $app)
            ->where('app_user_id', $appId)
            ->value('user_id');
    }

    /**
     * @param int $userId
     * @param string $app
     * @param string $appId
     * @param array $data
     * @param string $unionId
     *
     * @throws ServiceException
     */
    public function bindApp(int $userId, string $app, string $appId, array $data, string $unionId = ''): void
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
            'union_id' => $unionId,
        ]);
    }

    /**
     * @param string $app
     * @param string $appId
     * @param array $data
     * @param string $unionId
     * @return int
     */
    public function bindAppWithNewUser(string $app, string $appId, array $data, string $unionId = ''): int
    {
        return DB::transaction(function () use ($app, $appId, $data, $unionId) {
            $avatar = $data['avatar'] ?? '';

            $nickname = ($data['nickname'] ?? '') ?: Str::random(6);
            // 防止昵称过长
            if (mb_strlen($nickname) > 12) {
                $nickname = mb_substr($nickname, 0, 12);
            }
            $nickname .= '_' . Str::random(3);

            $user = $this->userService->createWithoutMobile($avatar, $nickname);

            Socialite::create([
                'user_id' => $user['id'],
                'app' => $app,
                'app_user_id' => $appId,
                'data' => serialize($data),
                'union_id' => $unionId,
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
        return Socialite::query()
            ->where('user_id', $userId)
            ->get()
            ->toArray();
    }

    /**
     * @param string $app
     * @param int $userId
     */
    public function cancelBind(string $app, int $userId): void
    {
        $bindApps = Socialite::query()
            ->where('user_id', $userId)
            ->get()
            ->keyBy('app')
            ->toArray();

        if (!isset($bindApps[$app])) {
            return;
        }

        Socialite::query()->where('id', $bindApps[$app]['id'])->delete();
    }

    /**
     * @param string $unionId
     * @return array
     */
    public function findUnionId(string $unionId): array
    {
        $record = Socialite::query()->where('union_id', $unionId)->first();
        return $record ? $record->toArray() : [];
    }

    /**
     * @param int $id
     * @param string $unionId
     */
    public function updateUnionId(int $id, string $unionId): void
    {
        Socialite::query()->where('id', $id)->update(['union_id' => $unionId]);
    }
}
