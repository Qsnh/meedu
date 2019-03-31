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
    public function searchHandler(SearchRequest $request)
    {
        $keywords = $request->input('keywords');
        $videos = collect([]);
        if ($keywords) {
            $videos = Video::where('title', 'like', "%{$keywords}%")
                ->published()
                ->show()
                ->orderByDesc('published_at')
                ->limit(20)
                ->get();
        }

        return v('frontend.search.index', compact('videos'));
    }
}
