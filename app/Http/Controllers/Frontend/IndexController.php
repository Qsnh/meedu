<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Models\Link;
use App\Events\AdFromEvent;
use Illuminate\Http\Request;
use App\Models\EmailSubscription;
use App\Repositories\IndexRepository;

class IndexController extends FrontendController
{
    public function index(Request $request, IndexRepository $repository)
    {
        $courses = $repository->recentPublishedAndShowCourses();
        $roles = $repository->roles();

        // AdFrom
        if ($request->input('from')) {
            event(new AdFromEvent($request->input('from')));
        }

        // 友情链接
        $links = Link::linksCache();

        ['title' => $title, 'keywords' => $keywords, 'description' => $description] = config('meedu.seo.index');

        return view(
            config('meedu.advance.template_index', 'frontend.index.index'),
            compact('courses', 'roles', 'title', 'keywords', 'description', 'links')
        );
    }

    /**
     * 邮件订阅.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscriptionHandler(Request $request)
    {
        EmailSubscription::saveFromRequest($request);

        return back();
    }
}
