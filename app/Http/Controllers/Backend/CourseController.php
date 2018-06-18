<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $courses = Course::when($keywords, function ($query) use ($keywords) {
            return $query->where('title', 'like', '%' . $keywords . '%');
        })
            ->select([
                'id', 'user_id', 'title', 'slug', 'thumb',
                'charge', 'short_description',
                'seo_keywords', 'seo_description',
                'published_at', 'is_show', 'created_at',
                'updated_at',
            ])
            ->orderByDesc('created_at')
            ->paginate(10);

        $courses->appends($request->input());

        return view('backend.course.index', compact('courses'));
    }

    public function create()
    {
        return view('backend.course.create');
    }

    public function store(CourseRequest $request, Course $course)
    {
        $course->fill($request->filldata())->save();
        flash('课程添加成功', 'success');
        return back();
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('backend.course.edit', compact('course'));
    }

    public function update(CourseRequest $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->fill($request->filldata())->save();
        flash('课程编辑成功', 'success');
        return back();
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if ($course->videos()->exists()) {
            flash('该课程下存在视频，无法删除');
        } else {
            $course->delete();
            flash('删除成功', 'success');
        }
        return back();
    }

}
