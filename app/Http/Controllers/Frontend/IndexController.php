<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;

class IndexController extends BaseController
{

    public function index()
    {
        $courses = Course::published()->show()->orderByDesc('created_at')->limit(3)->get();
        return view('frontend.index.index', compact('courses'));
    }

}
