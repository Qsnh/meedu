<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Models\Book;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::published()->show()->latest()->paginate(8);

        return view('frontend.book.index', compact('books'));
    }

    public function show($id)
    {
        $book = Book::published()->show()->whereId($id)->firstOrFail();

        return view('frontend.book.show', compact('book'));
    }

    public function buy($id)
    {
        $book = Book::published()->show()->whereId($id)->firstOrFail();

        return view('frontend.book.buy', compact('book'));
    }

    public function chapterShow($bookId, $chapterId)
    {
    }
}
