<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Constant\TableConstant;
use App\Models\AdministratorLog;
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
                $query->where('nick_name', 'like', '%' . $keywords . '%')
                    ->orWhere('mobile', 'like', '%' . $keywords . '%')
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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            array_merge(compact('keywords', 'roleId', 'tagId', 'createdAt', 'sort', 'order'), ['path' => $request->path()])
        );

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData($member);
    }

    public function store(MemberRequest $request)
    {
        $data = $request->filldata();

        $user = User::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_STORE,
            ['id' => $user['id'], 'nick_name' => $user['nick_name']]
        );

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
        // role_expired_at与role_id必须同时存在
        if (!$data['role_expired_at'] || !$data['role_id']) {
            $data['role_expired_at'] = null;
            $data['role_id'] = 0;
        } else {
            // 时间格式解析->兼容性更好
            $data['role_expired_at'] = Carbon::parse($data['role_expired_at'])->toDateTimeLocalString();
        }

        // 修改密码
        ($data['password'] ?? '') && $data['password'] = Hash::make($data['password']);

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_UPDATE,
            Arr::only($data, [
                'avatar', 'nick_name', 'mobile', 'is_lock', 'is_active', 'role_id', 'role_expired_at',
                'invite_user_id', 'invite_balance', 'invite_user_expired_at',
            ]),
            Arr::only($user->toArray(), [
                'avatar', 'nick_name', 'mobile', 'is_lock', 'is_active', 'role_id', 'role_expired_at',
                'invite_user_id', 'invite_balance', 'invite_user_expired_at',
            ])
        );

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData([
            'data' => $user,
        ]);
    }

    public function userCourses(Request $request, $id)
    {
        $data = UserCourse::query()->where('user_id', $id)->orderByDesc('created_at')->paginate($request->input('size', 20));
        $courseIds = get_array_ids($data->items(), 'course_id');
        $courses = Course::query()->whereIn('id', $courseIds)->select(['id', 'title', 'thumb', 'charge'])->get()->keyBy('id');

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData([
            'data' => $data,
        ]);
    }

    public function userCollect(Request $request, $id)
    {
        $data = UserLikeCourse::query()->where('user_id', $id)->orderByDesc('created_at')->paginate($request->input('size', 20));
        $courseIds = get_array_ids($data->items(), 'course_id');
        $courses = Course::query()->whereIn('id', $courseIds)->select(['id', 'title', 'thumb', 'charge'])->get()->keyBy('id');

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData([
            'data' => $data,
            'courses' => $courses,
        ]);
    }

    public function userOrders(Request $request, $id)
    {
        $status = (int)$request->input('status');

        $data = Order::query()
            ->with(['goods', 'paidRecords'])
            ->where('user_id', $id)
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderByDesc('created_at')
            ->paginate($request->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

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

            $userCreditRecordData = [
                'user_id' => $userId,
                'field' => 'credit1',
                'sum' => $credit1,
                'remark' => $remark,
            ];

            UserCreditRecord::create($userCreditRecordData);

            AdministratorLog::storeLog(
                AdministratorLog::MODULE_MEMBER,
                AdministratorLog::OPT_UPDATE,
                $userCreditRecordData
            );
        });

        return $this->success();
    }

    public function tagUpdate(Request $request, $userId)
    {
        $tagIdsStr = $request->input('tag_ids', '');
        $tagIds = $tagIdsStr ? explode(',', $tagIdsStr) : [];

        $user = User::query()->where('id', $userId)->firstOrFail();
        $userTagIds = $user->tags()->select(['id'])->get()->pluck('id')->toArray();

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_MEMBER_TAG,
            AdministratorLog::OPT_UPDATE,
            ['tag_ids' => $tagIds],
            ['tag_ids' => $userTagIds]
        );

        $user->tags()->sync($tagIds);

        return $this->success();
    }

    // 用户备注
    public function remark($id)
    {
        $userRemark = UserRemark::query()->where('user_id', $id)->first();
        $remark = $userRemark ? $userRemark['remark'] : '';

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData([
            'remark' => $remark,
        ]);
    }

    // 更新用户备注
    public function updateRemark(Request $request, $id)
    {
        $remark = $request->input('remark', '');
        $userRemark = UserRemark::query()->where('user_id', $id)->first();
        $oldRemark = '';

        if ($userRemark) {
            $oldRemark = $userRemark['remark'];
            $userRemark->update(['remark' => $remark]);
        } else {
            UserRemark::create([
                'user_id' => $id,
                'remark' => $remark,
            ]);
        }

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_UPDATE,
            ['remark' => $remark],
            ['remark' => $oldRemark]
        );

        return $this->success();
    }

    public function sendMessageMulti(Request $request)
    {
        $message = $request->input('message');
        $userIds = $request->input('user_ids');

        if (!is_array($userIds) || !$userIds) {
            return $this->error('请选择需要发送消息的用户');
        }
        if (!$message) {
            return $this->error('请输入需要发送的消息');
        }
        if (count($userIds) > 100) {
            return $this->error('单次发送消息不能超过100人');
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_STORE,
            compact('userIds', 'message')
        );

        $users = User::query()->whereIn('id', $userIds)->get();
        foreach ($users as $user) {
            $user->notify(new SimpleMessageNotification($message));
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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_STORE,
            compact('userId', 'message')
        );

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

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData([
            'data' => $records,
            'videos' => $videos,
        ]);
    }

    public function import(Request $request)
    {
        // ([0] => mobile, [1] => password, [2] => role_id, [3] => role_expired_at, [4] => is_lock, [5] => tag)
        $users = $request->input('users');
        if (!$users || !is_array($users)) {
            return $this->error(__('请导入数据'));
        }
        if (count($users) > 1000) {
            return $this->error(__('一次最多导入1000条数据'));
        }

        // 手机号重复检测
        $mobiles = array_column($users, 0);
        if (count(array_flip(array_flip($mobiles))) !== count($mobiles)) {
            return $this->error('手机号重复');
        }

        // VIP规范检测
        $roles = Role::query()->select(['id'])->get()->pluck('id')->toArray();
        $nowTime = time();
        foreach ($users as $userItem) {
            $roleId = (int)($userItem[2] ?? 0);
            $roleExpiredAt = $userItem[3] ?? null;
            // case1: 配置VIP-ID但是未配置VIP的过期时间
            if ($roleId && !$roleExpiredAt) {
                return $this->error(__('手机号[:mobile]配置了VIP但未配置过期时间', ['mobile' => $userItem[0] ?? '']));
            }
            // case2: 配置了VIP过期时间但是未配置VIP-ID
            if (!$roleId && $roleExpiredAt) {
                return $this->error(__('手机号[:mobile]配置了VIP过期时间但未配置VIP', ['mobile' => $userItem[0] ?? '']));
            }
            // case3: VIP-ID和VIP过期时间都配置了，但是过期时间小于当前时间
            if ($roleId && $roleExpiredAt && strtotime($roleExpiredAt) < $nowTime) {
                return $this->error(__('手机号[:mobile]的VIP过期时间小于当前时间', ['mobile' => $userItem[0] ?? '']));
            }
            // case4: VIP不存在
            if ($roleId && !in_array($roleId, $roles)) {
                return $this->error(__('手机号[:mobile]配置的VIP不存在', ['mobile' => $userItem[0] ?? '']));
            }
        }

        // 手机号存在检测
        foreach (array_chunk($mobiles, 500) as $item) {
            $exists = User::query()->whereIn('mobile', $item)->select(['mobile'])->get();
            if ($exists->isNotEmpty()) {
                return $this->error(sprintf(__('手机号%s已存在'), implode(',', $exists->pluck('mobile')->toArray())));
            }
        }

        // 标签处理
        $tags = [];
        foreach ($users as $userItem) {
            $tmpTagName = $userItem[5] ?? null;
            if (!$tmpTagName) {
                continue;
            }
            $tags = array_merge($tags, explode(',', $tmpTagName));
        }
        // 去重
        $tags = array_flip(array_flip($tags));
        // 读取已经存在的tag
        $existsTags = UserTag::query()->whereIn('name', $tags)->select(['id', 'name'])->get();
        // 筛选出未创建的tag
        $notExistsTags = array_diff($tags, $existsTags->pluck('name')->toArray());
        if ($notExistsTags) {
            // 批量插入
            $insertList = [];
            $now = Carbon::now()->toDateTimeLocalString();
            foreach ($notExistsTags as $tagName) {
                $insertList[] = ['name' => $tagName, 'created_at' => $now, 'updated_at' => $now];
            }
            UserTag::insert($insertList);
            // 读取新创建的tag
            $newTags = UserTag::query()->whereIn('name', $notExistsTags)->select(['id', 'name'])->get();
            $existsTags = $existsTags->merge($newTags);
        }
        $existsTags = $existsTags->keyBy('name')->toArray();
        foreach ($users as $key => $userItem) {
            $tmpTag = $userItem[5] ?? null;
            if (!$tmpTag) {
                $users[$key]['tag_ids'] = [];
                continue;
            }
            $tmpTags = explode(',', $tmpTag);
            $syncTagIds = [];
            foreach ($tmpTags as $tagName) {
                $syncTagIds[] = $existsTags[$tagName]['id'];
            }
            $users[$key]['tag_ids'] = $syncTagIds;
        }

        DB::transaction(function () use ($users) {
            $now = Carbon::now()->toDateTimeLocalString();
            foreach (array_chunk($users, 500) as $usersItem) {
                $data = [];
                if (!$usersItem) {
                    break;
                }

                AdministratorLog::storeLog(
                    AdministratorLog::MODULE_MEMBER,
                    AdministratorLog::OPT_IMPORT,
                    ['mobiles' => array_column($usersItem, 0)]
                );

                // 批量插入用户
                foreach ($usersItem as $item) {
                    $tmpMobile = $item[0];
                    // 密码
                    $tmpPassword = $item[1];
                    // VIP处理l
                    $tmpRoleId = (int)($item[2] ?? 0);
                    $tmpRoleExpiredAt = null;
                    if ($item[3]) {
                        $tmpRoleExpiredAt = Carbon::parse($item[3])->toDateTimeLocalString();
                    }
                    // 是否锁定
                    $tmpIsLock = (int)($item[4] ?? 0);

                    $data[] = [
                        'mobile' => $tmpMobile,
                        'avatar' => url(config('meedu.member.default_avatar')),
                        'nick_name' => mb_substr($tmpMobile, 0, 8) . '_' . Str::random(5),
                        'is_active' => (int)config('meedu.member.is_active_default'),
                        'is_lock' => $tmpIsLock,
                        'password' => Hash::make($tmpPassword),
                        'is_password_set' => 0,
                        'is_set_nickname' => 0,
                        'role_id' => $tmpRoleId,
                        'role_expired_at' => $tmpRoleExpiredAt,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                User::insert($data);

                // 标签关联数据缓存
                $tagInsertList = [];
                $mobile2idMap = User::query()->whereIn('mobile', array_column($data, 'mobile'))->select(['id', 'mobile'])->get()->keyBy('mobile');
                foreach ($usersItem as $item) {
                    if (!$item['tag_ids']) {
                        continue;
                    }
                    $userId = $mobile2idMap[$item[0]]['id'];
                    foreach ($item['tag_ids'] as $tagId) {
                        $tagInsertList[] = [
                            'user_id' => $userId,
                            'tag_id' => $tagId,
                        ];
                    }
                }
                $tagInsertList && DB::table(TableConstant::TABLE_USER_TAG)->insert($tagInsertList);
            }
        });

        return $this->success();
    }

    public function updateFieldMulti(Request $request)
    {
        $userIds = $request->input('user_ids');
        if (!$userIds || !is_array($userIds)) {
            return $this->error('请选择需要修改的用户');
        }

        // 要更改的字段
        $field = $request->input('field');
        // 欲更改为的字段值
        $value = $request->input('value');
        // 如果更改为roleId的话则需要传递该参数
        $roleExpiredAt = $request->input('role_expired_at');
        // 如果修改的是标签的话则需要传递该参数
        $tagIds = $request->input('tag_ids');

        // 必须是白名单内的字段才可以更改
        $fieldsWhitelist = [
            'is_lock', 'is_active', 'role_id', 'role_expired_at', 'is_password_set', 'is_set_nickname', 'tag',
        ];
        if (!$field || !in_array($field, $fieldsWhitelist)) {
            return $this->error('待修改字段不合法');
        }

        // 如果选择了有效的roleId的话，那么role_expired_at则必须是有效的时间
        if ($field === 'role_id' && (int)$value && !$roleExpiredAt) {
            return $this->error('请选择VIP过期时间');
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER,
            AdministratorLog::OPT_UPDATE,
            compact('field', 'value', 'roleExpiredAt', 'tagIds', 'userIds')
        );

        if ($field === 'tag') {
            $tagIds = $tagIds && is_array($tagIds) ? $tagIds : [];
            $users = User::query()->whereIn('id', $userIds)->get();
            foreach ($users as $userItem) {
                $userItem->tags()->sync($tagIds);
            }
        } else {
            // 整数值字段，对即将修改的值进行取整处理
            $intFields = ['is_lock', 'is_active', 'is_password_set', 'is_set_nickname', 'role_id'];
            if (in_array($field, $intFields)) {
                $value = (int)$value;
            }
            $updateData[$field] = $value;

            if ($field === 'role_id') {
                $updateData['role_expired_at'] = Carbon::parse($roleExpiredAt)->toDateTimeLocalString();
            }

            User::query()->whereIn('id', $userIds)->update($updateData);
        }

        return $this->success();
    }
}
