<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Frontend\Member\AvatarChangeRequest;
use App\Http\Requests\Frontend\Member\MemberPasswordResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends BaseController
{

    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

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

        if (! Hash::check($oldPassword, $this->user->password)) {
            flash('原密码不正确');
            return back();
        }

        $this->user->password = bcrypt($newPassword);
        $this->user->save();

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

        $this->user->avatar = $url;
        $this->user->save();

        flash('头像更换成功', 'success');
        return back();
    }

}
