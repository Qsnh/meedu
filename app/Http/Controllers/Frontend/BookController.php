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
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Repositories\BookRepository;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $books = Book::published()->show()->latest()->paginate(8);

        ['title' => $title, 'keywords' => $keywords, 'description' => $description] = config('meedu.seo.book_list');

        return view('frontend.book.index', compact('books', 'title', 'keywords', 'description'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $book = Book::published()->show()->whereId($id)->firstOrFail();

        $title = sprintf('电子书《%s》', $book->title);
        $keywords = $book->keywords;
        $description = $book->decsription;

        return view('frontend.book.show', compact('book', 'title', 'keywords', 'description'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBuyPage($id)
    {
        $book = Book::published()->show()->whereId($id)->firstOrFail();

        return view('frontend.book.buy', compact('book'));
    }

    /**
     * @param BookRepository $repository
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function buyHandler(BookRepository $repository, $id)
    {
        $book = Book::published()->show()->whereId($id)->firstOrFail();
        $order = $repository->createOrder(Auth::user(), $book);
        if (! ($order instanceof Order)) {
            flash($order, 'warning');

            return back();
        }

        flash('下单成功，请尽快支付', 'success');

        return redirect(route('order.show', $order->order_id));
    }

    /**
     * @param $bookId
     * @param $chapterId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function chapter($bookId, $chapterId)
    {
        $book = Book::published()->show()->whereId($bookId)->firstOrFail();
        if ($book->charge > 0 && ! Auth::user()->canSeeThisBook($book)) {
            flash('请先购买本书', 'warning');

            return redirect(route('member.book.buy', $book));
        }
        $chapter = $book->chapters()->whereId($chapterId)->firstOrFail();

        $title = sprintf('章节 %s - 《%s》', $chapter->title, $book->title);

        return view('frontend.book.chapter', compact('book', 'chapter', 'title'));
    }
}
