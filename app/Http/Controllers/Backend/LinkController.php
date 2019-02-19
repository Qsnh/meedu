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

use App\Models\Link;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LinkRequest;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::orderBy('sort')->get();

        return view('backend.link.index', compact('links'));
    }

    public function create()
    {
        return view('backend.link.create');
    }

    public function store(LinkRequest $request)
    {
        Link::create($request->filldata());
        flash('添加成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $link = Link::findOrFail($id);

        return view('backend.link.edit', compact('link'));
    }

    public function update(LinkRequest $request, $id)
    {
        $role = Link::findOrFail($id);
        $role->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        Link::destroy($id);
        flash('删除成功', 'success');

        return back();
    }
}
