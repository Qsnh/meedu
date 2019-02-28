<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\SearchRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
