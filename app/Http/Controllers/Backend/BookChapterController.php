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

use App\Models\BookChapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BookChapterRequest;

class BookChapterController extends Controller
{
    public function index(Request $request)
    {
        $books = BookChapter::publishedDesc()->paginate($request->input('page_size', 10));

        return view('backend.book_chapter.index', compact('books'));
    }

    public function create()
    {
        return view('backend.book_chapter.create');
    }

    public function store(BookChapterRequest $request)
    {
        BookChapter::create($request->filldata());
        flash('创建成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $book = BookChapter::findOrFail($id);

        return view('backend.book_chapter.edit', compact('book'));
    }

    public function update(BookChapterRequest $request, $id)
    {
        $book = BookChapter::findOrFail($id);
        $book->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        BookChapter::destroy($id);
        flash('删除成功', 'success');

        return back();
    }
}
