<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Video;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $courses = Course::show()
            ->published()
            ->orderByDesc('created_at')
            ->paginate($request->input('page_size', 10));
        return \App\Http\Resources\Course::collection($courses);
    }

    public function show($id)
    {
        $course = Course::show()
            ->published()
            ->whereId($id)
            ->firstOrFail();
        return new \App\Http\Resources\Course($course);
    }

    public function videos($id)
    {
        $course = Course::show()
            ->published()
            ->whereId($id)
            ->firstOrFail();
        $videos = $course->getAllPublishedAndShowVideosCache();
        return Video::collection($videos);
    }

}
