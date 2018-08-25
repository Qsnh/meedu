<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Video;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{

    public function show($courseId, $id, $slug)
    {
        $video = Video::published()->show()->whereId($id)->firstOrFail();
        return view('frontend.video.show', compact('video'));
    }

}
