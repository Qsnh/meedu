<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::show()->published()->orderByDesc('created_at')->get();
        return view('frontend.course.index', compact('courses'));
    }

    public function show($id, $slug)
    {
        $course = Course::show()->published()->whereId($id)->firstOrFail();
        return view('frontend.course.show', compact('course'));
    }

}
