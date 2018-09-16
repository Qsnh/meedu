<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use App\Models\EmailSubscription;
use Illuminate\Http\Request;

class IndexController extends BaseController
{

    public function index()
    {
        $courses = Course::published()->show()->orderByDesc('created_at')->limit(3)->get();
        return view('frontend.index.index', compact('courses'));
    }

    public function subscriptionHandler(Request $request)
    {
        $email = $request->input('email', '');
        if (!$email) {
            flash('请输入邮箱', 'warning');
            return back();
        }
        $exists = EmailSubscription::whereEmail($email)->exists();
        if (!$exists) {
            EmailSubscription::create(compact('email'));
        }
        flash('订阅成功', 'success');
        return back();
    }

}
