<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nick_name' => 'required|unique:users',
            'mobile' => 'bail|required|unique:users',
            'password' => 'bail|required|min:6|max:16|confirmed',
        ], [
            'nick_name' => [
                'required' => '请输入呢称',
                'unique' => '呢称已经存在',
            ],
            'mobile' => [
                'required' => '请输入手机号',
                'unique' => '手机号已经存在',
            ],
            'password' => [
                'required' => '请输入密码',
                'min' => '密码长度不能小于6个字符',
                'max' => '密码长度不能超过16个字符',
                'confirmed' => '两次输入的密码不一致',
            ],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nick_name' => $data['nick_name'] ?? User::randomNickName(),
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
            'is_active' => config('meedu.member.is_active_default'),
            'is_lock' => config('meedu.member.is_lock_default'),
        ]);
    }
}
