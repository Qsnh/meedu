<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use App\Services\Member\Models\UserTag;

class MemberTagController extends BaseController
{
    public function index(Request $request)
    {
        $tags = UserTag::query()->select(['id', 'name'])->orderByDesc('id')->paginate($request->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER_TAG,
            AdministratorLog::OPT_VIEW,
            []
        );

        return $this->successData($tags);
    }

    public function create()
    {
        return $this->success();
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        if (!$name) {
            return $this->error(__('参数错误'));
        }

        if (UserTag::query()->where('name', $name)->exists()) {
            return $this->error(__('用户标签已存在'));
        }

        $data = ['name' => $name];

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER_TAG,
            AdministratorLog::OPT_STORE,
            $data
        );

        UserTag::create($data);

        return $this->success();
    }

    public function edit($id)
    {
        $tag = UserTag::query()->where('id', $id)->firstOrFail();
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER_TAG,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );
        return $this->successData($tag);
    }

    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        if (!$name) {
            return $this->error(__('参数错误'));
        }

        $tag = UserTag::query()->where('id', $id)->firstOrFail();

        if (UserTag::query()->where('name', $name)->where('id', '<>', $tag['id'])->exists()) {
            return $this->error(__('用户标签已存在'));
        }

        $updateData = ['name' => $name];

        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_MEMBER_TAG,
            AdministratorLog::OPT_UPDATE,
            $updateData,
            Arr::only($tag->toArray(), ['name'])
        );

        $tag->fill($updateData)->save();

        return $this->success();
    }

    public function destroy($id)
    {
        $tag = UserTag::query()->where('id', $id)->firstOrFail();

        if ($tag->users()->count() > 0) {
            return $this->error(__('当前标签已关联用户，无法删除'));
        }

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MEMBER_TAG,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        $tag->delete();
        return $this->success();
    }
}
