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
use App\Services\Order\Models\PromoCode;
use App\Http\Requests\Backend\PromoCodeRequest;

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
}
