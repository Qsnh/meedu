<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Http\Controllers\Backend\Api\V1;

use Illuminate\Http\Request;
use App\Events\VideoUploadedEvent;
use App\Services\Course\Models\MediaVideo;

class MediaVideoController extends BaseController
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords');
        $isOpen = (int)$request->input('is_open');

        $videos = MediaVideo::query()
            ->select([
                'id', 'title', 'thumb', 'duration', 'size', 'storage_driver', 'storage_file_id',
                'transcode_status', 'ref_count', 'created_at', 'updated_at',
            ])
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('title', 'like', '%' . $keywords . '%');
            })
            ->when(in_array($isOpen, [0, 1]), function ($query) use ($isOpen) {
                $query->where('is_open', $isOpen);
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
        $isOpen = (int)$request->input('is_open');

        $mediaVideo = MediaVideo::create([
            'title' => $title,
            'thumb' => $thumb,
            'duration' => $duration,
            'size' => $size,
            'storage_driver' => $storageDriver,
            'storage_file_id' => $storageFileId,
            'is_open' => $isOpen,
        ]);

        event(new VideoUploadedEvent($storageFileId, $storageDriver, 'media_video', $mediaVideo['id']));

        return $this->successData($mediaVideo);
    }
}
