<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::orderByDesc('created_at')->get();
        return view('frontend.course.index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('frontend.course.show', compact('course'));
    }

}
