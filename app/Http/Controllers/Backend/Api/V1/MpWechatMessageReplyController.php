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

use Illuminate\Http\Request;
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

        return $this->successData([
            'data' => $data,
        ]);
    }

    public function create()
    {
        $types = [
            [
                'id' => 'text',
                'name' => '文本消息',
            ],
            [
                'id' => 'event',
                'name' => '事件',
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
                return $this->error('规则不合格');
            }
        }
        MpWechatMessageReply::create($data);
        return $this->success();
    }

    public function edit($id)
    {
        $data = MpWechatMessageReply::query()->where('id', $id)->firstOrFail();
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
                return $this->error('规则不合格');
            }
        }

        $message = MpWechatMessageReply::query()->where('id', $id)->firstOrFail();
        $message->fill($data)->save();
        return $this->success();
    }

    public function destroy($id)
    {
        MpWechatMessageReply::destroy($id);
        return $this->success();
    }
}
