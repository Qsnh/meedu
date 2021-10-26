<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Illuminate\Support\Str;
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
use App\Services\Member\Models\UserProfile;
use App\Http\Requests\Backend\MemberRequest;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Member\Models\UserTagRelation;
use App\Services\Course\Models\CourseUserRecord;
use App\Services\Member\Models\UserCreditRecord;
use App\Services\Member\Models\UserJoinRoleRecord;
use App\Services\Member\Models\UserVideoWatchRecord;
use App\Events\UserInviteBalanceWithdrawHandledEvent;
use App\Services\Member\Models\UserInviteBalanceWithdrawOrder;
use App\Services\Member\Notifications\SimpleMessageNotification;

class MemberController extends BaseController
{
    public function index(Request $request)
    {
        // 过滤条件
        $keywords = $request->input('keywords', '');
        $roleId = $request->input('role_id');
        $tagId = $request->input('tag_id');
        $createdAt = $request->input('created_at');

        // 排序字段
        $sort = $request->input('sort', 'id');
        $order = $request->input('order', 'desc');

        $members = User::query()
            ->with(['role:id,name', 'tags:id,name'])
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('nick_name', $keywords)
                    ->orWhere('mobile', $keywords)
                    ->orWhere('id', $keywords);
            })
            ->when($roleId, function ($query) use ($roleId) {
                $query->whereRoleId($roleId);
            })
            ->when($tagId, function ($query) use ($tagId) {
                $userIds = UserTagRelation::query()->where('tag_id', $tagId)->select(['user_id'])->get()->pluck('user_id');
                $query->whereIn('id', $userIds);
            })
            ->when($createdAt, function ($query) use ($createdAt) {
                $query->whereBetween('created_at', $createdAt);
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
        $roles = Role::query()->select(['id', 'name'])->orderByDesc('id')->get();
        $tags = UserTag::query()->select(['id', 'name'])->orderByDesc('id')->get();
        return $this->successData(compact('roles', 'tags'));
    }

    public function edit($id)
    {
        $member = User::query()
            ->with(['tags:id,name', 'remark:user_id,remark'])
            ->where('id', $id)
            ->firstOrFail();

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
        $user = User::query()->where('id', $id)->firstOrFail();
        $data = $request->only([
            'avatar', 'nick_name', 'mobile', 'password',
            'is_lock', 'is_active', 'role_id', 'role_expired_at',
            'invite_user_id', 'invite_balance', 'invite_user_expired_at',
        ]);

        $profileData = $request->only([
            'real_name', 'gender', 'age', 'birthday', 'profession', 'address', 'graduated_school', 'diploma',
            'id_number', 'id_frontend_thumb', 'id_backend_thumb', 'id_hand_thumb',
        ]);
        if ($profileData) {
            $profileData['real_name'] = $profileData['real_name'] ?? '';
            $profileData['gender'] = $profileData['gender'] ?? '';
            $profileData['age'] = $profileData['age'] ?? 0;
            $profileData['birthday'] = $profileData['birthday'] ?? '';
            $profileData['profession'] = $profileData['profession'] ?? '';
            $profileData['address'] = $profileData['address'] ?? '';
            $profileData['graduated_school'] = $profileData['graduated_school'] ?? '';
            $profileData['diploma'] = $profileData['diploma'] ?? '';
            $profileData['id_number'] = $profileData['id_number'] ?? '';
            $profileData['id_frontend_thumb'] = $profileData['id_frontend_thumb'] ?? '';
            $profileData['id_backend_thumb'] = $profileData['id_backend_thumb'] ?? '';
            $profileData['id_hand_thumb'] = $profileData['id_hand_thumb'] ?? '';
        }

        // 手机号校验
        if (User::query()->where('mobile', $data['mobile'])->where('id', '<>', $user['id'])->exists()) {
            return $this->error(__('手机号已存在'));
        }
        // 昵称校验
        if (User::query()->where('nick_name', $data['nick_name'])->where('id', '<>', $user['id'])->exists()) {
            return $this->error(__('昵称已经存在'));
        }

        // 字段默认值
        $data['role_id'] = (int)($data['role_id'] ?? 0);
        $data['role_expired_at'] = $data['role_expired_at'] ?? null;
        // 时间格式不允许空字符串
        $data['role_expired_at'] = $data['role_expired_at'] ?: null;
        // 如果删除了时间，那么将roleId重置为0
        $data['role_expired_at'] || $data['role_id'] = 0;
        // 如果roleId为0的话，那么role_expired_at也重置为null
        $data['role_id'] || $data['role_expired_at'] = null;
        // 修改密码
        ($data['password'] ?? '') && $data['password'] = Hash::make($data['password']);

        $user->fill($data)->save();

        // UserProfile
        if ($profileData) {
            $userProfile = UserProfile::query()->where('user_id', $id)->first();
            if ($userProfile) {
                $userProfile->save($profileData);
            } else {
                UserProfile::create(array_merge($profileData, ['user_id' => $id]));
            }
        }

        return $this->success();
    }

    public function detail($id)
    {
        $user = User::query()
            ->with([
                'role:id,name',
                'invitor:id,nick_name,mobile,avatar',
                'profile', 'tags:id,name',
                'remark:user_id,remark',
            ])
            ->where('id', $id)
            ->firstOrFail();

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
            ->with(['role:id,name'])
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

    public function tagUpdate(Request $request, $userId)
    {
        $tagIds = explode(',', $request->input('tag_ids', ''));

        $user = User::query()->where('id', $userId)->firstOrFail();

        $user->tags()->sync($tagIds);

        return $this->success();
    }

    // 用户备注
    public function remark($id)
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

    public function sendMessage(Request $request, $userId)
    {
        $user = User::query()->where('id', $userId)->firstOrFail();
        $message = $request->input('message');
        if (!$message) {
            return $this->error(__('参数错误'));
        }

        $user->notify(new SimpleMessageNotification($message));

        return $this->success();
    }

    public function userVideoWatchRecords(Request $request, $id)
    {
        $records = UserVideoWatchRecord::query()
            ->select([
                'id', 'user_id', 'course_id', 'video_id', 'watch_seconds', 'watched_at', 'created_at',
            ])
            ->where('user_id', $id)
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        $videos = [];
        $videoIds = array_column($records->items(), 'video_id');
        if ($videoIds) {
            $videos = Video::query()->whereIn('id', $videoIds)->select(['id', 'title'])->get()->keyBy('id');
        }

        return $this->successData([
            'data' => $records,
            'videos' => $videos,
        ]);
    }

    public function import(Request $request)
    {
        // ([0] => mobile, [1] => password)
        $users = $request->input('users');
        if (!$users || !is_array($users)) {
            return $this->error(__('请导入数据'));
        }

        $mobiles = array_column($users, 0);

        // 手机号存在检测
        $mobileChunk = array_chunk($mobiles, 500);
        foreach ($mobileChunk as $item) {
            $exists = User::query()->whereIn('mobile', $item)->select(['mobile'])->get();
            if ($exists->isNotEmpty()) {
                return $this->error(sprintf(__('账号%s已存在'), implode(',', $exists->pluck('mobile')->toArray())));
            }
        }

        DB::transaction(function () use ($users) {
            // 批量添加
            foreach (array_chunk($users, 500) as $usersItem) {
                $data = [];
                foreach ($usersItem as $item) {
                    $data[] = [
                        'mobile' => $item[0],
                        'avatar' => url(config('meedu.member.default_avatar')),
                        'nick_name' => mb_substr($item[0], 0, 8) . '_' . Str::random(5),
                        'is_active' => config('meedu.member.is_active_default'),
                        'is_lock' => config('meedu.member.is_lock_default'),
                        'password' => Hash::make($item[1]),
                        'created_at' => Carbon::now(),
                    ];
                }
                if (!$data) {
                    continue;
                }

                User::insert($data);
            }
        });

        return $this->success();
    }
}
