<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use Illuminate\Support\Facades\DB;
use App\Services\Order\Models\PromoCode;
use App\Http\Requests\Backend\PromoCodeRequest;
use App\Http\Requests\Backend\PromoCodeGeneratorRequest;

class PromoCodeController extends BaseController
{
    public function index(Request $request)
    {
        $key = $request->input('key');
        $userId = $request->input('user_id');
        $expiredAt = $request->input('expired_at');
        $createdAt = $request->input('created_at');

        // 排序
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');

        $items = PromoCode::query()
            ->when($key, function ($query) use ($key) {
                $query->where('code', 'like', '%' . $key . '%');
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($expiredAt, function ($query) use ($expiredAt) {
                $query->whereBetween('expired_at', [Carbon::parse($expiredAt[0]), Carbon::parse($expiredAt[1])]);
            })
            ->when($createdAt, function ($query) use ($createdAt) {
                $query->whereBetween('created_at', [Carbon::parse($createdAt[0]), Carbon::parse($createdAt[1])]);
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_PROMO_CODE,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData($items);
    }

    public function store(PromoCodeRequest $request)
    {
        $data = $request->filldata();

        if (strtolower(substr($data['code'], 0, 1)) === 'u') {
            return $this->error(__('优惠码格式错误'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_PROMO_CODE,
            AdministratorLog::OPT_STORE,
            $data
        );

        PromoCode::create($data);

        return $this->success();
    }

    public function edit($id)
    {
        $info = PromoCode::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_PROMO_CODE,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($info);
    }

    public function update(PromoCodeRequest $request, $id)
    {
        $data = $request->filldata();
        $info = PromoCode::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_PROMO_CODE,
            AdministratorLog::OPT_UPDATE,
            $data,
            Arr::only($info->toArray(), [
                'user_id', 'code', 'expired_at',
                'invite_user_reward', 'invited_user_reward',
                'use_times', 'used_times',
            ])
        );

        $info->fill($data)->save();

        return $this->success();
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if ($ids) {
            PromoCode::query()->whereIn('id', $ids)->delete();

            AdministratorLog::storeLog(
                AdministratorLog::MODULE_PROMO_CODE,
                AdministratorLog::OPT_DESTROY,
                compact('ids')
            );
        }

        return $this->success();
    }

    public function import(Request $request)
    {
        $data = $request->input('data');
        if (!$data) {
            return $this->error(__('数据为空'));
        }

        // 删除表头
        unset($data[0]);
        if (empty($data)) {
            return $this->error(__('数据为空'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_PROMO_CODE,
            AdministratorLog::OPT_IMPORT,
            compact('data')
        );

        $insertData = [];
        foreach ($data as $index => $line) {
            $code = $line[0] ?? '';
            $invitedReward = (int)($line[1] ?? 0);
            $expiredAt = $line[2] ?? '';
            $useTimes = (int)($line[3] ?? 0);

            if (!$code && !$invitedReward && !$expiredAt) {
                // 完全空值的一行[往往是文件的结尾]
                continue;
            }

            if (!$code) {
                return $this->error(sprintf(__('第%d行优惠码为空'), $index + 1));
            }
            if (!$invitedReward) {
                return $this->error(sprintf(__('第%d行优惠码折扣为0'), $index + 1));
            }
            if (!$expiredAt) {
                return $this->error(sprintf(__('第%d行优惠码过期时间为空'), $index + 1));
            }

            $insertData[] = [
                'code' => $code,
                'expired_at' => Carbon::parse($expiredAt)->format('Y-m-d H:i:s'),
                'invited_user_reward' => $invitedReward,
                'use_times' => $useTimes,
            ];
        }

        if (!$insertData) {
            return $this->error('empty data.2');
        }

        $existsData = PromoCode::query()->whereIn('code', array_column($insertData, 'code'))->select(['code'])->get()->pluck('code')->toArray();
        if ($existsData) {
            return $this->error(sprintf(__('优惠码%s已存在'), implode(',', $existsData)));
        }

        PromoCode::insert($insertData);

        return $this->success();
    }

    public function generator(PromoCodeGeneratorRequest $request)
    {
        $prefix = $request->input('prefix');
        $num = $request->input('num', 1);
        $money = $request->input('money');
        $expiredAt = Carbon::parse($request->input('expired_at'))->format('Y-m-d H:i:s');

        $start = PromoCode::withTrashed()->where('code', 'like', $prefix . '%')->count() + 1;

        $insertData = [];
        $now = Carbon::now()->toDateTimeLocalString();
        while ($num > 0) {
            $insertData[] = [
                'code' => $prefix . ($start + $num),
                'expired_at' => $expiredAt,
                'invite_user_reward' => 0,
                'invited_user_reward' => $money,
                'use_times' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $num--;
        }
        $insertData = array_reverse($insertData);

        $exists = PromoCode::query()
            ->whereIn('code', array_column($insertData, 'code'))
            ->exists();
        if ($exists) {
            return $this->error(__('该优惠码前缀无法生成优惠码'));
        }

        DB::transaction(function () use ($insertData) {
            foreach (array_chunk($insertData, 200) as $chunk) {
                AdministratorLog::storeLog(
                    AdministratorLog::MODULE_PROMO_CODE,
                    AdministratorLog::OPT_IMPORT,
                    compact('chunk')
                );

                PromoCode::insert($chunk);
            }
        });

        return $this->success();
    }
}
