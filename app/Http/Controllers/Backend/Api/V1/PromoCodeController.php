<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Order\Models\PromoCode;
use App\Http\Requests\Backend\PromoCodeRequest;
use App\Http\Requests\Backend\PromoCodeGeneratorRequest;

class PromoCodeController extends BaseController
{
    public function index(Request $request)
    {
        $key = $request->input('key');
        $userId = $request->input('user_id');
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');

        $items = PromoCode::query()
            ->when($key, function ($query) use ($key) {
                $query->where('code', 'like', '%' . $key . '%');
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 10));

        return $this->successData($items);
    }

    public function store(PromoCodeRequest $request)
    {
        PromoCode::create($request->filldata());

        return $this->success();
    }

    public function edit($id)
    {
        $info = PromoCode::findOrFail($id);

        return $this->successData($info);
    }

    public function update(PromoCodeRequest $request, $id)
    {
        $item = PromoCode::findOrFail($id);
        $item->fill($request->filldata())->save();

        return $this->success();
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);
        $ids && PromoCode::destroy($ids);

        return $this->success();
    }

    public function import(Request $request)
    {
        $data = $request->input('data');
        if (!$data) {
            return $this->error('empty data');
        }

        // 删除表头
        unset($data[0]);
        if (empty($data)) {
            return $this->error('empty data.1');
        }

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
                return $this->error(sprintf('第%d行优惠码为空', $index + 1));
            }
            if (!$invitedReward) {
                return $this->error(sprintf('第%d行折扣为0', $index + 1));
            }
            if (!$expiredAt) {
                return $this->error(sprintf('第%d行过期时间为空', $index + 1));
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
            return $this->error(sprintf('下面优惠码重复：%s', implode(',', $existsData)));
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

        $start = (int)PromoCode::query()->withTrashed()->where('code', 'like', $prefix . '%')->count() + 1;
        $insertData = [];
        while ($num > 0) {
            $insertData[] = [
                'code' => $prefix . ($start + $num),
                'expired_at' => $expiredAt,
                'invite_user_reward' => 0,
                'invited_user_reward' => $money,
                'use_times' => 1,
            ];
            $num--;
        }

        $existsData = PromoCode::query()->whereIn('code', array_column($insertData, 'code'))->select(['code'])->get()->pluck('code')->toArray();
        if ($existsData) {
            return $this->error('该前缀下有优惠码重复，无法生成');
        }

        PromoCode::insert($insertData);

        return $this->success();
    }
}
