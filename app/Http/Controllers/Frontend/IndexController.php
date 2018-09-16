<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use App\Models\EmailSubscription;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends FrontendController
{

    public function index()
    {
        $courses = Cache::remember('index_recent_course', 360, function () {
            return Course::published()->show()->orderByDesc('created_at')->limit(3)->get();
        });
        $roles = Cache::remember('index_roles', 360, function () {
            return Role::orderByDesc('weight')->limit(3)->get();
        });
        return view('frontend.index.index', compact('courses', 'roles'));
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
