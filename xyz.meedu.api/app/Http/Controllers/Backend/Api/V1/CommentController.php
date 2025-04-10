<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Services\Member\Models\User;
use App\Meedu\ServiceV2\Models\Comment;

class CommentController extends BaseController
{
    public function index(Request $request)
    {
        // 参数获取和验证
        $rt = (int)$request->input('rt');
        $rid = (int)$request->input('rid');
        $userId = (int)$request->input('user_id');
        $createdAt = $request->input('created_at');
        $isCheck = (int)$request->input('is_check');

        if ($createdAt && !is_array($createdAt)) {
            return $this->error(__('参数错误'));
        }

        // 记录操作日志
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_COMMENT,
            AdministratorLog::OPT_VIEW,
            compact('rt', 'rid', 'userId', 'createdAt', 'isCheck')
        );

        // 查询评论列表
        $comments = Comment::query()
            ->when($rt, function ($query) use ($rt) {
                $query->where('rt', $rt);
            })
            ->when($rid, function ($query) use ($rid) {
                $query->where('rid', $rid);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($createdAt, function ($query) use ($createdAt) {
                $query->whereBetween('created_at', [
                    Carbon::parse($createdAt[0])->startOfDay()->toDateTimeLocalString(),
                    Carbon::parse($createdAt[1])->endOfDay()->toDateTimeLocalString(),
                ]);
            })
            ->when(-1 !== $isCheck, function ($query) use ($isCheck) {
                $query->where('is_check', $isCheck);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        $total = $comments->total();
        $data = $comments->items();

        if ($data) {
            // 获取用户信息
            $users = User::query()
                ->whereIn('id', array_column($data, 'user_id'))
                ->select(['id', 'nick_name', 'avatar'])
                ->get()
                ->keyBy('id')
                ->unique()
                ->toArray();
            $users = array_column($users, null, 'id');
            foreach ($data as $key => $item) {
                $data[$key]['user'] = $users[$item['user_id']] ?? [];
            }
        }

        return $this->successData([
            'data' => $data,
            'total' => $total,
        ]);
    }

    public function check(Request $request)
    {
        $ids = $request->input('ids', []);
        $checkAction = $request->input('check_action');

        if (!$ids || !is_array($ids)) {
            return $this->error(__('参数错误'));
        }

        if (!in_array($checkAction, ['pass', 'reject'])) {
            return $this->error(__('参数错误'));
        }

        // 记录操作日志
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_COMMENT,
            AdministratorLog::OPT_UPDATE,
            compact('ids', 'checkAction')
        );

        if ('pass' === $checkAction) {
            // 批量更新评论状态
            Comment::query()
                ->whereIn('id', $ids)
                ->update([
                    'is_check' => 1,
                    'check_reason' => $this->adminInfo()['name'],
                ]);
        } else {
            Comment::query()->whereIn('id', $ids)->delete();
            Comment::query()->whereIn('parent_id', $ids)->delete();
        }

        return $this->success();
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!$ids || !is_array($ids)) {
            return $this->error(__('参数错误'));
        }

        // 记录操作日志
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_COMMENT,
            AdministratorLog::OPT_DESTROY,
            compact('ids')
        );

        // 批量软删除评论
        Comment::destroy($ids);
        Comment::query()->whereIn('parent_id', $ids)->delete();

        return $this->success();
    }
}
