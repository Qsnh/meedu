<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Member\Services\UserService;
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
    protected $redirectTo = '/member';

    protected $userService;

    /**
     * Create a new controller instance.
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('guest');
        $this->userService = $userService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nick_name' => 'required|unique:users',
            'mobile' => 'bail|required|unique:users',
            'password' => 'bail|required|min:6|max:16|confirmed',
        ], [
            'nick_name.required' => __('nick_name.required'),
            'nick_name.unique' => __('nick_name.unique'),
            'mobile.required' => __('mobile.required'),
            'mobile.unique' => __('mobile.unique'),
            'password.required' => __('password.required'),
            'password.min' => __('password.min'),
            'password.max' => __('password.max'),
            'password.confirmed' => __('password.confirmed'),
        ]);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function create(array $data)
    {
        return $this->userService->createWithMobile($data['mobile'], $data['password'], $data['nick_name']);
    }
}
