<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\MeeduErrorResponseJsonException;
use App\Http\Requests\Frontend\PasswordResetRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    public function showPage()
    {
        return view('auth.passwords.find');
    }

    public function handler(PasswordResetRequest $request)
    {
        $captcha = Session::get('password_reset_captcha');
        if (! $captcha || $captcha != $request->input('sms_captcha')) {
            flash('短信验证码错误');
            return back();
        }

        $user = User::whereMobile($request->input('mobile'))->first();
        if (! $user) {
            flash('用户不存在');
            return back();
        }

        $user->password = bcrypt($request->input('password'));
        $user->save();

        Session::forget('password_reset_captcha');

        flash('密码修改成功', 'success');
        return redirect(route('login'));
    }
}
