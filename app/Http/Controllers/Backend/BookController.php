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

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BookRequest;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::latest()->paginate($request->input('page_size', 10));

        return view('backend.book.index', compact('books'));
    }

    public function create()
    {
        return view('backend.book.create');
    }

    public function store(BookRequest $request)
    {
        Book::create($request->filldata());
        flash('创建成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view('backend.book.edit', compact('book'));
    }

    public function update(BookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        Book::destroy($id);
        flash('删除成功', 'success');

        return back();
    }
}
