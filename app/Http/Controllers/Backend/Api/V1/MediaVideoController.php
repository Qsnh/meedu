<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use App\Models\MediaVideo;
use Illuminate\Http\Request;

class MediaVideoController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords');
        $videos = MediaVideo::query()
            ->select([
                'id', 'title', 'thumb', 'duration', 'size', 'storage_driver', 'storage_file_id',
                'transcode_status', 'ref_count', 'created_at', 'updated_at',
            ])
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->orderByDesc('id')
            ->paginate($request->input('size', 10));

        return $this->successData($videos);
    }

    public function store(Request $request)
    {
        $title = mb_substr(strip_tags($request->input('title', '')), 0, 255);
        $thumb = $request->input('thumb', '');
        $duration = (int)$request->input('duration');
        $size = (int)$request->input('size');
        $storageDriver = $request->input('storage_driver');
        $storageFileId = $request->input('storage_file_id');

        $video = MediaVideo::create([
            'title' => $title,
            'thumb' => $thumb,
            'duration' => $duration,
            'size' => $size,
            'storage_driver' => $storageDriver,
            'storage_file_id' => $storageFileId,
        ]);

        return $this->successData($video);
    }
}
