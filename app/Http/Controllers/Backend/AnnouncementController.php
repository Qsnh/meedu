<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{

    public function index()
    {
        $announcements = Announcement::with('administrator')->orderByDesc('created_at')->paginate(10);
        return view('backend.announcement.index', compact('announcements'));
    }

    public function create()
    {
        return view('backend.announcement.create');
    }

    public function store(AnnouncementRequest $request)
    {
        admin()->announcements()->save(new Announcement($request->filldata()));
        flash('添加成功', 'success');
        return back();
    }

    public function edit($id)
    {
        $announcement = admin()->announcements()->whereId($id)->firstOrFail();
        return view('backend.announcement.edit', compact('announcement'));
    }

    public function update(AnnouncementRequest $request, $id)
    {
        $announcement = admin()->announcements()->whereId($id)->firstOrFail();
        $announcement->fill($request->filldata())->save();
        flash('编辑成功', 'success');
        return back();
    }

    public function destroy($id)
    {
        Announcement::destroy($id);
        flash('删除成功', 'success');
        return back();
    }

}
