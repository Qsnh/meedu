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

use App\Models\Nav;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\NavRequest;

class NavController extends Controller
{
    public function index()
    {
        $rows = Nav::orderBy('id')->paginate(10);

        return view('backend.nav.index', compact('rows'));
    }

    public function create()
    {
        return view('backend.nav.create');
    }

    public function store(NavRequest $request)
    {
        Nav::create($request->filldata());
        flash('添加成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $one = Nav::findOrFail($id);

        return view('backend.nav.edit', compact('one'));
    }

    public function update(NavRequest $request, $id)
    {
        $one = Nav::findOrFail($id);
        $one->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        Nav::destroy($id);
        flash('删除成功', 'success');

        return back();
    }
}
