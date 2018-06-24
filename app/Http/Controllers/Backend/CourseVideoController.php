<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CourseVideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseVideoController extends Controller
{

    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');

        $videos = Video::with(['course'])
            ->when($keywords, function ($query) use ($keywords) {
                return $query->where('title', 'like', "%{$keywords}%");
            })
            ->orderByDesc('published_at')
            ->select([
                'id', 'user_id', 'course_id', 'title',
                'slug', 'url', 'charge', 'view_num',
                'short_description', 'description',
                'seo_keywords', 'seo_description',
                'published_at', 'is_show', 'created_at',
                'updated_at',
            ])
            ->paginate($request->input('page_size', 10));

        $videos->appends($request->input());

        return view('backend.video.index', compact('videos'));
    }

    public function create()
    {
        return view('backend.video.create');
    }

    public function store(CourseVideoRequest $request, Video $video)
    {
        $video->fill($request->filldata())->save();
        flash('添加成功', 'success');
        return back();
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('backend.video.edit', compact('video'));
    }

    public function update(CourseVideoRequest $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->fill($request->filldata())->save();
        flash('编辑成功', 'success');
        return back();
    }

    public function destroy($id)
    {
        Video::destroy($id);
        flash('删除成功', 'success');
        return back();
    }

}
