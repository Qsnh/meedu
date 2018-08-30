<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\Member\AvatarChangeRequest;
use App\Http\Requests\Frontend\Member\MemberPasswordResetRequest;
use App\Models\UserJoinRoleRecord;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends BaseController
{

    public function index()
    {
        return view('frontend.member.index');
    }

    public function showPasswordResetPage()
    {
        return view('frontend.member.password_reset');
    }

    public function passwordResetHandler(MemberPasswordResetRequest $request)
    {
        [$oldPassword, $newPassword] = $request->filldata();

        $user = Auth::user();

        if (! Hash::check($oldPassword, $user->password)) {
            flash('原密码不正确');
            return back();
        }

        $user->password = bcrypt($newPassword);
        $user->save();

        flash('密码修改成功', 'success');
        return back();
    }

    public function showAvatarChangePage()
    {
        return view('frontend.member.avatar');
    }

    public function avatarChangeHandler(AvatarChangeRequest $request)
    {
        [$path, $url] = $request->filldata();

        $user = Auth::user();
        $user->avatar = $url;
        $user->save();

        flash('头像更换成功', 'success');
        return back();
    }

    public function showJoinRoleRecordsPage()
    {
        $records = UserJoinRoleRecord::whereUserId(Auth::id())->orderByDesc('expired_at')->paginate(8);
        return view('frontend.member.join_role_records', compact('records'));
    }

    public function showMessagesPage()
    {
        $messages = new Paginator(Auth::user()->notifications, 10);
        $messages->setPath(route('member.messages'));
        return view('frontend.member.messages', compact('messages'));
    }

    public function showBuyCoursePage()
    {
        $courses = Auth::user()->joinCourses()->orderByDesc('pivot_created_at')->paginate(15);
        return view('frontend.member.buy_course', compact('courses'));
    }

}
