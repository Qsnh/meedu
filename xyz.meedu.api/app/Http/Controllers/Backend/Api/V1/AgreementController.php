<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Models\AdministratorLog;
use Illuminate\Support\Facades\DB;
use App\Constant\AgreementConstant;
use App\Events\AgreementChangeEvent;
use App\Meedu\ServiceV2\Models\Agreement;
use App\Http\Requests\Backend\AgreementRequest;
use App\Meedu\ServiceV2\Models\AgreementUserRecord;

class AgreementController extends BaseController
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $isActive = $request->input('is_active');

        $agreements = Agreement::query()
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when($isActive !== null && $isActive !== -1, function ($query) use ($isActive) {
                $query->where('is_active', $isActive);
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_AGREEMENT,
            AdministratorLog::OPT_VIEW,
            compact('type', 'isActive')
        );

        return $this->successData($agreements);
    }

    public function create()
    {
        $types = AgreementConstant::TYPES;
        return $this->successData(compact('types'));
    }

    public function store(AgreementRequest $request)
    {
        $data = $request->filldata();

        // 检查版本号是否已存在
        $existingVersion = Agreement::query()
            ->where('type', $data['type'])
            ->where('version', $data['version'])
            ->whereNull('deleted_at')
            ->exists();

        if ($existingVersion) {
            return $this->error(__('该协议类型下的版本号已存在'));
        }

        DB::transaction(function () use ($data) {
            // 如果设置为生效版本，需要将同类型的其他协议设为非生效
            if ($data['is_active']) {
                Agreement::query()
                    ->where('type', $data['type'])
                    ->where('is_active', 1)
                    ->update(['is_active' => 0, 'effective_at' => null]);
            }

            $agreement = Agreement::query()->create($data);

            AdministratorLog::storeLog(
                AdministratorLog::MODULE_AGREEMENT,
                AdministratorLog::OPT_STORE,
                $data
            );

            event(new AgreementChangeEvent($agreement['id'], $agreement['type']));
        });

        return $this->success();
    }

    public function edit($id)
    {
        $agreement = Agreement::query()->findOrFail($id);
        $types = AgreementConstant::TYPES;

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_AGREEMENT,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData(compact('agreement', 'types'));
    }

    public function update(AgreementRequest $request, $id)
    {
        $agreement = Agreement::query()->findOrFail($id);

        $data = $request->filldata();

        // 检查版本号是否已存在（排除当前记录）
        $existingVersion = Agreement::query()
            ->where('type', $data['type'])
            ->where('version', $data['version'])
            ->where('id', '!=', $id)
            ->whereNull('deleted_at')
            ->exists();

        if ($existingVersion) {
            return $this->error(__('该协议类型下的版本号已存在'));
        }

        DB::transaction(function () use ($data, $agreement, $id) {
            // 如果设置为生效版本，需要将同类型的其他协议设为非生效
            if ($data['is_active']) {
                Agreement::query()
                    ->where('type', $data['type'])
                    ->where('is_active', 1)
                    ->where('id', '!=', $id)
                    ->update(['is_active' => 0, 'effective_at' => null]);
            }

            $agreement->update($data);

            AdministratorLog::storeLogDiff(
                AdministratorLog::MODULE_AGREEMENT,
                AdministratorLog::OPT_UPDATE,
                $data,
                $agreement->getOriginal()
            );

            event(new AgreementChangeEvent($agreement['id'], $agreement['type']));
        });

        return $this->success();
    }

    public function destroy($id)
    {
        $agreement = Agreement::query()->findOrFail($id);

        // 检查是否为生效版本
        if ($agreement['is_active']) {
            return $this->error(__('不能删除生效版本的协议'));
        }

        $agreement->delete();

        event(new AgreementChangeEvent($agreement['id'], $agreement['type']));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_AGREEMENT,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );

        return $this->success();
    }

    public function records(Request $request, $id)
    {
        $agreementId = $request->input('agreement_id');
        $userId = $request->input('user_id');
        $dateRange = $request->input('date_range');

        $records = AgreementUserRecord::query()
            ->with(['user:id,nick_name,mobile,avatar'])
            ->when($agreementId, function ($query) use ($agreementId) {
                $query->where('agreement_id', $agreementId);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($dateRange, function ($query) use ($dateRange) {
                $query->whereBetween('agreed_at', $dateRange);
            })
            ->where('agreement_id', $id)
            ->orderByDesc('agreed_at')
            ->paginate($request->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_AGREEMENT,
            AdministratorLog::OPT_VIEW,
            compact('agreementId', 'userId', 'dateRange')
        );

        return $this->successData($records);
    }
}
