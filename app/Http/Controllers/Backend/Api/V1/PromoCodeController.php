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

use App\Services\Order\Models\PromoCode;
use App\Http\Requests\Backend\PromoCodeRequest;

class PromoCodeController extends BaseController
{
    public function index()
    {
        $items = PromoCode::orderByDesc('id')->paginate(12);

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

    public function destroy($id)
    {
        PromoCode::destroy($id);

        return $this->success();
    }
}
