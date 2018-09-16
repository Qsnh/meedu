<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\EmailSubscriptionRequest;
use App\Jobs\DispatchEmailSubscriptionJob;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{

    public function create()
    {
        return view('backend.subscription.create');
    }

    public function store(EmailSubscriptionRequest $request)
    {
        [$title, $content] = $request->filldata();
        dispatch(new DispatchEmailSubscriptionJob($title, $content));
        flash('任务正在执行中，请耐心等待', 'success');
        return back();
    }

}
