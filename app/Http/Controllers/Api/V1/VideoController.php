<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\Video;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{

    public function show($id)
    {
        $video = $video = Video::published()
            ->show()
            ->whereId($id)
            ->firstOrFail();
        return new \App\Http\Resources\Video($video);
    }

    public function playUrl($id)
    {
        $video = $video = Video::published()
            ->show()
            ->whereId($id)
            ->firstOrFail();
        $user = Auth::user();
        if (! $user->canSeeThisVideo($video)) {
            throw new Exception('当前视频无法观看');
        }

        return aliyun_play_url($video);
    }

}
