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

use App\Models\FaqCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FaqCategoryRequest;

class FaqCategoryController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::sortAsc()->get();

        return view('backend.faq_category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.faq_category.create');
    }

    public function store(FaqCategoryRequest $request)
    {
        FaqCategory::create($request->filldata());
        flash('添加成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $category = FaqCategory::findOrFail($id);

        return view('backend.faq_category.edit', compact('category'));
    }

    public function update(FaqCategoryRequest $request, $id)
    {
        $category = FaqCategory::findOrFail($id);
        $category->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        $category = FaqCategory::findOrFail($id);
        if ($category->articles()->exists()) {
            flash('该分类下存在文章，无法删除');
        } else {
            $category->delete();
            flash('删除成功', 'success');
        }

        return back();
    }
}
