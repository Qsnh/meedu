<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');
        $courses = Course::select(['id', 'title'])
            ->when($keywords, function ($query) use ($keywords) {
                return $query->where('title', 'like', "%{$keywords}%");
            })
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
        return $courses;
    }

}
