<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend;

use App\Models\AdFrom;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AdFromRequest;

class AdFromController extends Controller
{
    public function index()
    {
        $rows = AdFrom::orderBy('id')->paginate(10);

        return view('backend.adfrom.index', compact('rows'));
    }

    public function create()
    {
        return view('backend.adfrom.create');
    }

    public function store(AdFromRequest $request)
    {
        AdFrom::create($request->filldata());
        flash('添加成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $one = AdFrom::findOrFail($id);

        return view('backend.adfrom.edit', compact('one'));
    }

    public function update(AdFromRequest $request, $id)
    {
        $one = AdFrom::findOrFail($id);
        $one->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        AdFrom::destroy($id);
        flash('删除成功', 'success');

        return back();
    }
}
