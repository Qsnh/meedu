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
use App\Meedu\ServiceV2\Models\User;
use App\Services\Order\Models\PromoCode;
use App\Services\Order\Models\OrderPaidRecord;
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
        $status = $request->input('status');

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
            ->when($status === 'active', function ($query) {
                // 生效中：剩余次数>0 且未过期
                $query->where(function ($q) {
                    $q->where('use_times', 0)
                        ->orWhereRaw('use_times > used_times');
                })->where('expired_at', '>', Carbon::now());
            })
            ->when($status === 'used_up', function ($query) {
                // 已用完：剩余次数=0
                $query->where('use_times', '>', 0)
                    ->whereRaw('use_times <= used_times');
            })
            ->when($status === 'expired', function ($query) {
                // 已过期：当前时间>过期时间
                $query->where('expired_at', '<=', Carbon::now());
            })
            ->when($status === 'used_up_and_expired', function ($query) {
                // 已用完+已过期
                $query->where('use_times', '>', 0)
                    ->whereRaw('use_times <= used_times')
                    ->where('expired_at', '<=', Carbon::now());
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_PROMO_CODE,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData(
            [
                'data' => $items->items(),
                'total' => $items->total(),
            ]
        );
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

        if (!$ids) {
            return $this->success();
        }

        // 查询所有要删除的优惠码
        $promoCodes = PromoCode::query()->whereIn('id', $ids)->get();

        // 分离已使用和未使用的优惠码
        $usedCodes = $promoCodes->filter(function ($code) {
            return $code->used_times > 0;
        });

        $unusedCodes = $promoCodes->filter(function ($code) {
            return $code->used_times == 0;
        });

        // 只删除未使用的优惠码
        $deletedIds = $unusedCodes->pluck('id')->toArray();
        if ($deletedIds) {
            PromoCode::query()->whereIn('id', $deletedIds)->forceDelete();

            AdministratorLog::storeLog(
                AdministratorLog::MODULE_PROMO_CODE,
                AdministratorLog::OPT_DESTROY,
                [
                    'ids' => $deletedIds,
                    'skipped_count' => $usedCodes->count(),
                ]
            );
        }

        // 构建返回信息
        $message = '操作完成';
        if ($deletedIds && $usedCodes->count() > 0) {
            $skippedCodes = $usedCodes->pluck('code')->toArray();
            $message = sprintf(
                '成功删除 %d 个优惠码，跳过 %d 个已使用的优惠码：%s',
                count($deletedIds),
                $usedCodes->count(),
                implode('、', array_slice($skippedCodes, 0, 10)) . ($usedCodes->count() > 10 ? '等' : '')
            );
        } elseif ($deletedIds) {
            $message = sprintf('成功删除 %d 个优惠码', count($deletedIds));
        } elseif ($usedCodes->count() > 0) {
            return $this->error('所选优惠码均已使用，无法删除');
        }

        return $this->success($message);
    }

    public function import(Request $request)
    {
        $data = $request->input('data');
        $line = (int)$request->input('line', 2);
        if (!$data) {
            return $this->error(__('数据为空'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_PROMO_CODE,
            AdministratorLog::OPT_IMPORT,
            compact('data')
        );

        $insertData = [];
        $now = Carbon::now()->toDateTimeLocalString();
        foreach ($data as $index => $lineData) {
            $code = $lineData[0] ?? '';
            $invitedReward = (int)($lineData[1] ?? 0);
            $expiredAt = $lineData[2] ?? '';
            $useTimes = (int)($lineData[3] ?? 0);

            if (!$code && !$invitedReward && !$expiredAt) {
                // 完全空值的一行[往往是文件的结尾]
                continue;
            }

            if (!$code) {
                return $this->error(sprintf(__('第%d行优惠码为空'), $index + $line));
            }
            if (!$invitedReward) {
                return $this->error(sprintf(__('第%d行优惠码折扣为0'), $index + $line));
            }
            if (!$expiredAt) {
                return $this->error(sprintf(__('第%d行优惠码过期时间为空'), $index + $line));
            }

            $insertData[] = [
                'code' => $code,
                'expired_at' => Carbon::parse($expiredAt)->format('Y-m-d H:i:s'),
                'invited_user_reward' => $invitedReward,
                'use_times' => $useTimes,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!$insertData) {
            return $this->error('empty data.2');
        }

        // 检查导入文件中是否有重复的优惠码
        $codeLineMap = []; // 记录每个优惠码出现的行号
        foreach ($insertData as $index => $item) {
            $code = $item['code'];
            if (!isset($codeLineMap[$code])) {
                $codeLineMap[$code] = [];
            }
            $codeLineMap[$code][] = $index + $line; // 记录Excel中的实际行号
        }

        $duplicateInfo = [];
        foreach ($codeLineMap as $code => $lines) {
            if (count($lines) > 1) {
                $duplicateInfo[] = sprintf('%s(第%s行)', $code, implode(',', $lines));
            }
        }

        if ($duplicateInfo) {
            return $this->error(sprintf(__('导入文件中存在重复的优惠码：%s'), implode('；', $duplicateInfo)));
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
        $useTimes = $request->input('use_times', 1);

        $start = PromoCode::withTrashed()->where('code', 'like', $prefix . '%')->count() + 1;

        $insertData = [];
        $now = Carbon::now()->toDateTimeLocalString();
        while ($num > 0) {
            $insertData[] = [
                'code' => $prefix . ($start + $num),
                'expired_at' => $expiredAt,
                'invite_user_reward' => 0,
                'invited_user_reward' => $money,
                'use_times' => $useTimes,
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

    public function usageDetails(Request $request, $id)
    {
        $page = max((int)$request->get('page', 1), 1);
        $size = max((int)$request->get('size', 10), 10);
        $mobile = $request->get('mobile');
        $orderStatus = $request->get('order_status');
        $promoCode = PromoCode::query()->where('id', $id)->firstOrFail();

        $query = OrderPaidRecord::query()
            ->where('paid_type', OrderPaidRecord::PAID_TYPE_PROMO_CODE)
            ->where('paid_type_id', $id)
            ->with(['order:id,order_id,user_id,charge,status,created_at']);

        // 如果提供了手机号，先查询匹配的用户ID
        if ($mobile) {
            $userIdsByMobile = User::query()
                ->where('mobile', $mobile)
                ->pluck('id')
                ->toArray();

            if (empty($userIdsByMobile)) {
                // 如果没有匹配的用户，返回空结果
                return $this->successData([
                    'data' => [],
                    'total' => 0,
                    'promo_code' => [
                        'id' => $promoCode['id'],
                        'code' => $promoCode['code'],
                        'invited_user_reward' => $promoCode['invited_user_reward'],
                        'use_times' => $promoCode['use_times'],
                        'used_times' => $promoCode['used_times'],
                    ],
                ]);
            }

            $query->whereIn('user_id', $userIdsByMobile);
        }

        // 如果提供了订单状态，过滤关联订单的状态
        if ($orderStatus !== null && $orderStatus !== '') {
            $query->whereHas('order', function ($q) use ($orderStatus) {
                $q->where('status', $orderStatus);
            });
        }

        $total = $query->count();

        $records = $query
            ->orderBy('created_at', 'desc')
            ->forPage($page, $size)
            ->get();

        // 获取所有用户ID
        $userIds = $records->pluck('user_id')->unique()->toArray();

        // 批量查询用户信息
        $users = User::query()
            ->whereIn('id', $userIds)
            ->select(['id', 'nick_name', 'avatar', 'mobile'])
            ->get()
            ->keyBy('id');

        // 组装数据
        $data = $records->map(function ($record) use ($users) {
            $tmpUserItem = $users[$record->user_id] ?? [];

            return [
                'id' => $record->id,
                'order_id' => $record->order ? $record->order->order_id : '',
                'user_id' => $record->user_id,
                'user_nick_name' => $tmpUserItem['nick_name'] ?? '',
                'user_mobile' => $tmpUserItem['mobile'] ?? '',
                'user_avatar' => $tmpUserItem['avatar'] ?? '',
                'paid_total' => $record->paid_total,
                'order_charge' => $record->order ? $record->order->charge : 0,
                'order_status' => $record->order ? $record->order->status : 0,
                'order_status_text' => $record->order ? $record->order->status_text : '',
                'created_at' => $record->created_at,
            ];
        });

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_PROMO_CODE,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData([
            'data' => $data,
            'total' => $total,
            'promo_code' => [
                'id' => $promoCode['id'],
                'code' => $promoCode['code'],
                'invited_user_reward' => $promoCode['invited_user_reward'],
                'use_times' => $promoCode['use_times'],
                'used_times' => $promoCode['used_times'],
            ],
        ]);
    }
}
