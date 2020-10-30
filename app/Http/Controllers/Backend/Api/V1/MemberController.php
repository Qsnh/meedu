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

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use Illuminate\Support\Facades\Hash;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserTag;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserRemark;
use App\Http\Requests\Backend\MemberRequest;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Member\Models\UserTagRelation;
use App\Services\Course\Models\CourseUserRecord;
use App\Services\Member\Models\UserCreditRecord;
use App\Services\Member\Models\UserJoinRoleRecord;
use App\Events\UserInviteBalanceWithdrawHandledEvent;
use App\Services\Member\Models\UserInviteBalanceWithdrawOrder;

class MemberController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $roleId = $request->input('role_id');
        $tagId = $request->input('tag_id');
        $sort = $request->input('sort', 'created_at');
        $order = $request->input('order', 'desc');

        $members = User::with(['role', 'tags'])
            ->when($keywords, function ($query) use ($keywords) {
                return $query->where('nick_name', 'like', "%{$keywords}%")
                    ->orWhere('mobile', 'like', "%{$keywords}%");
            })
            ->when($roleId, function ($query) use ($roleId) {
                $query->whereRoleId($roleId);
            })
            ->when($tagId, function ($query) use ($tagId) {
                $userIds = UserTagRelation::query()->where('tag_id', $tagId)->select(['user_id'])->get()->pluck('user_id');
                $query->whereIn('id', $userIds);
            })
            ->orderBy($sort, $order)
            ->paginate($request->input('size', 10));

        // 全部VIP
        $roles = Role::query()->select(['id', 'name'])->get();
        // 全部TAG
        $tags = UserTag::query()->select(['id', 'name'])->get();
        // 会员备注
        $userRemarks = UserRemark::query()
            ->whereIn('user_id', array_column($members->items(), 'id'))
            ->select(['user_id', 'remark'])
            ->get()
            ->keyBy('user_id');

        return $this->successData([
            'data' => $members,
            'roles' => $roles,
            'tags' => $tags,
            'user_remarks' => $userRemarks,
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        return $this->successData(compact('roles'));
    }

    public function edit($id)
    {
        $member = User::findOrFail($id);

        return $this->successData($member);
    }

    public function store(MemberRequest $request)
    {
        User::create($request->filldata());

        return $this->success();
    }

    // 用户提现订单
    public function inviteBalanceWithdrawOrders(Request $request)
    {
        $userId = $request->input('user_id');
        $status = (int)$request->input('status');
        $name = $request->input('name');

        $orders = UserInviteBalanceWithdrawOrder::query()
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($name, function ($query) use ($name) {
                $query->where('channel_name', 'like', '%' . $name . '%');
            })
            ->when($status !== -1, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        $users = User::query()
            ->select(['id', 'nick_name', 'mobile', 'avatar'])
            ->whereIn('id', array_column($orders->items(), 'user_id'))
            ->get()
            ->keyBy('id');

        return $this->successData(compact('orders', 'users'));
    }

    // 用户提现订单处理
    public function inviteBalanceWithdrawOrderHandle(Request $request)
    {
        $ids = $request->input('ids');
        $status = $request->input('status');
        $remark = $request->input('remark', '');

        UserInviteBalanceWithdrawOrder::query()
            ->whereIn('id', $ids)
            ->update([
                'status' => $status,
                'remark' => $remark,
            ]);

        // 提现处理后事件
        event(new UserInviteBalanceWithdrawHandledEvent($ids, $status));

        return $this->success();
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();
        $data = Arr::only($data, [
            'avatar', 'nick_name', 'mobile', 'password',
            'is_lock', 'is_active', 'role_id', 'role_expired_at',
            'invite_user_id', 'invite_balance', 'invite_user_expired_at',
        ]);

        // 字段默认值
        $data['role_id'] = (int)($data['role_id'] ?? 0);
        $data['role_expired_at'] = $data['role_expired_at'] ?? null;
        // 时间格式不允许空字符串
        $data['role_expired_at'] = $data['role_expired_at'] ?: null;
        // 如果删除了时间，那么将roleId重置为0
        $data['role_expired_at'] || $data['role_id'] = 0;
        // 如果roleId为0的话，那么role_expired_at也重置为0
        $data['role_id'] || $data['role_expired_at'] = null;

        // 修改密码
        ($data['password'] ?? '') && $data['password'] = Hash::make($data['password']);

        $user->fill($data)->save();

        return $this->success();
    }

    public function detail($id)
    {
        $user = User::query()->with(['role', 'invitor', 'profile'])->where('id', $id)->firstOrFail();

        return $this->successData([
            'data' => $user,
        ]);
    }

    public function userCourses(Request $request, $id)
    {
        $data = UserCourse::query()->where('user_id', $id)->orderByDesc('created_at')->paginate($request->input('size', 20));
        $courseIds = get_array_ids($data->items(), 'course_id');
        $courses = Course::query()->whereIn('id', $courseIds)->select(['id', 'title', 'thumb', 'charge'])->get()->keyBy('id');
        return $this->successData([
            'data' => $data,
            'courses' => $courses,
        ]);
    }

    public function userVideos(Request $request, $id)
    {
        $data = UserVideo::query()->where('user_id', $id)->orderByDesc('created_at')->paginate($request->input('size', 20));
        $videoIds = get_array_ids($data->items(), 'video_id');
        $videos = Video::query()->whereIn('id', $videoIds)->select(['id', 'title', 'charge'])->get()->keyBy('id');
        return $this->successData([
            'data' => $data,
            'videos' => $videos,
        ]);
    }

    public function userRoles(Request $request, $id)
    {
        $data = UserJoinRoleRecord::query()
            ->with(['role'])
            ->where('user_id', $id)
            ->orderByDesc('created_at')
            ->paginate($request->input('size', 20));

        return $this->successData([
            'data' => $data,
        ]);
    }

    public function userCollect(Request $request, $id)
    {
        $data = UserLikeCourse::query()->where('user_id', $id)->orderByDesc('created_at')->paginate($request->input('size', 20));
        $courseIds = get_array_ids($data->items(), 'course_id');
        $courses = Course::query()->whereIn('id', $courseIds)->select(['id', 'title', 'thumb', 'charge'])->get()->keyBy('id');
        return $this->successData([
            'data' => $data,
            'courses' => $courses,
        ]);
    }

    public function userHistory(Request $request, $id)
    {
        $data = CourseUserRecord::query()->where('user_id', $id)->orderByDesc('created_at')->paginate($request->input('size', 20));
        $courseIds = get_array_ids($data->items(), 'course_id');
        $courses = Course::query()->whereIn('id', $courseIds)->select(['id', 'title', 'thumb', 'charge'])->get()->keyBy('id');
        return $this->successData([
            'data' => $data,
            'courses' => $courses,
        ]);
    }

    public function userOrders(Request $request, $id)
    {
        $data = Order::query()
            ->with(['goods', 'paidRecords'])
            ->where('user_id', $id)
            ->orderByDesc('created_at')
            ->paginate($request->input('size', 20));

        return $this->successData([
            'data' => $data,
        ]);
    }

    public function userInvite(Request $request, $id)
    {
        $data = User::query()
            ->select(['id', 'nick_name', 'avatar', 'mobile', 'created_at', 'invite_user_expired_at'])
            ->where('invite_user_id', $id)
            ->paginate($request->input('size', 20));

        return $this->successData([
            'data' => $data,
        ]);
    }

    // 积分记录
    public function credit1Records(Request $request, $id)
    {
        $records = UserCreditRecord::query()
            ->where('user_id', $id)
            ->where('field', 'credit1')
            ->orderByDesc('id')
            ->paginate($request->input('size', 20));
        return $this->successData([
            'data' => $records,
        ]);
    }

    // 积分变动
    public function credit1Change(Request $request)
    {
        $userId = $request->input('user_id');
        $credit1 = $request->input('credit1');
        $remark = $request->input('remark', '');
        DB::transaction(function () use ($userId, $credit1, $remark) {
            $user = User::query()->where('id', $userId)->firstOrFail();

            $user->credit1 += $credit1;
            $user->save();

            UserCreditRecord::create([
                'user_id' => $userId,
                'field' => 'credit1',
                'sum' => $credit1,
                'remark' => $remark,
            ]);
        });

        return $this->success();
    }

    // 用户标签更新
    public function tagUpdate(Request $request, $userId)
    {
        $tags = $request->input('tags');

        $tagIdMap = UserTag::query()->whereIn('name', $tags)->select(['name', 'id'])->get()->keyBy('name')->toArray();
        $tagIds = [];

        foreach ($tags as $item) {
            $id = $tagIdMap[$item]['id'] ?? 0;
            if (!$id) {
                // 标签不存在
                $tmpTag = UserTag::create(['name' => $item]);
                $id = $tmpTag['id'];
            }

            $tagIds[] = $id;
        }

        $user = User::query()->where('id', $userId)->firstOrFail();
        $user->tags()->sync($tagIds);

        return $this->success();
    }

    // 用户备注
    public function remark(Request $request, $id)
    {
        $userRemark = UserRemark::query()->where('user_id', $id)->first();
        $remark = $userRemark ? $userRemark['remark'] : '';
        return $this->successData([
            'remark' => $remark,
        ]);
    }

    // 更新用户备注
    public function updateRemark(Request $request, $id)
    {
        $remark = $request->input('remark', '');
        $userRemark = UserRemark::query()->where('user_id', $id)->first();
        if ($userRemark) {
            $userRemark->update(['remark' => $remark]);
        } else {
            UserRemark::create([
                'user_id' => $id,
                'remark' => $remark,
            ]);
        }

        return $this->success();
    }
}
