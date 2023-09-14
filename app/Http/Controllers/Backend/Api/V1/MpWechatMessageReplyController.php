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
use App\Services\Other\Models\MpWechatMessageReply;
use App\Http\Requests\Backend\MpWechatMessageReplyRequest;

class MpWechatMessageReplyController extends BaseController
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $keywords = $request->input('keywords');

        $data = MpWechatMessageReply::query()
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when($keywords, function ($query) use ($keywords) {
                $query->orWhere('rule', 'like', '%' . $keywords . '%')
                    ->orWhere('event_key', 'like', '%' . $keywords . '%');
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MP_MESSAGE,
            AdministratorLog::OPT_VIEW,
            compact('type', 'keywords')
        );

        return $this->successData([
            'data' => $data,
        ]);
    }

    public function create()
    {
        $types = [
            [
                'id' => 'text',
                'name' => __('文本消息'),
            ],
            [
                'id' => 'event',
                'name' => __('事件'),
            ]
        ];

        return $this->successData([
            'types' => $types,
        ]);
    }

    public function store(MpWechatMessageReplyRequest $request)
    {
        $data = $request->filldata();
        if ($data['type'] === MpWechatMessageReply::TYPE_TEXT && $data['rule']) {
            try {
                preg_match('#' . $data['rule'] . '#', 'test');
            } catch (\Exception $e) {
                return $this->error(__('无效规则'));
            }
        }
        MpWechatMessageReply::create($data);

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MP_MESSAGE,
            AdministratorLog::OPT_STORE,
            $data
        );

        return $this->success();
    }

    public function edit($id)
    {
        $data = MpWechatMessageReply::query()->where('id', $id)->firstOrFail();

        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MP_MESSAGE,
            AdministratorLog::OPT_VIEW,
            compact('id')
        );

        return $this->successData([
            'data' => $data,
        ]);
    }

    public function update(MpWechatMessageReplyRequest $request, $id)
    {
        $data = $request->filldata();
        if ($data['type'] === MpWechatMessageReply::TYPE_TEXT && $data['rule']) {
            try {
                preg_match('#' . $data['rule'] . '#', 'test');
            } catch (\Exception $e) {
                return $this->error(__('无效规则'));
            }
        }
        $message = MpWechatMessageReply::query()->where('id', $id)->firstOrFail();
        AdministratorLog::storeLogDiff(
            AdministratorLog::MODULE_MP_MESSAGE,
            AdministratorLog::OPT_UPDATE,
            $data,
            Arr::only($message->toArray(), [
                'type', 'event_type', 'event_key', 'rule', 'reply_content',
            ])
        );
        $message->fill($data)->save();
        return $this->success();
    }

    public function destroy($id)
    {
        MpWechatMessageReply::destroy($id);
        AdministratorLog::storeLog(
            AdministratorLog::MODULE_MP_MESSAGE,
            AdministratorLog::OPT_DESTROY,
            compact('id')
        );
        return $this->success();
    }
}
