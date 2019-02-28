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

use App\Models\Video;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SearchRequest;

class SearchController extends Controller
{
    public function showPage()
    {
        return v('frontend.search.search');
    }

    public function searchHandler(SearchRequest $request)
    {
        $keywords = $request->post('keywords');
        $videos = Video::where('name', 'like', "%{$keywords}%")->orderByDesc('created_at')->limit(20);

        return v('frontend.search.search', compact('videos'));
    }
}
