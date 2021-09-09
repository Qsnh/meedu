<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Frontend\SearchRequest;
use App\Services\Other\Proxies\SearchRecordService;
use App\Services\Other\Interfaces\SearchRecordServiceInterface;

class SearchController extends BaseController
{
    public function searchHandler(SearchRequest $request)
    {
        ['keywords' => $keywords] = $request->filldata();
        $keywords = strip_tags(clean($keywords));

        $data = collect([]);
        if ($keywords) {
            /**
             * @var SearchRecordService $searchService
             */
            $searchService = app()->make(SearchRecordServiceInterface::class);

            $data = $searchService->search($keywords, 10);
            $data->appends(['keywords' => $keywords]);
        }

        $title = __('搜索');

        return v('frontend.search.index', compact('data', 'title', 'keywords'));
    }
}
