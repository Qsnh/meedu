@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="member-dashboard">
                    <div class="user-info">
                        <div class="user-avatar">
                            <img src="{{$user['avatar']}}" width="100" height="100">
                        </div>
                        <div class="user-nickname">
                            <span>{{$user['nick_name']}}</span>
                            @if(!$user['is_set_nickname'])
                                <a href="javascript:void(0)" class="nickname-edit-button"
                                   onclick="showAuthBox('nickname-change')">
                                    <img src="/images/icons/member/nickname-edit.png" width="18" height="18">
                                </a>
                            @endif
                        </div>
                        <div class="user-option">
                            <a href="javascript:void(0);" class="change-avatar-button"
                               onclick="showAuthBox('avatar-change')">更换头像</a>
                        </div>
                    </div>
                    @if(app()->make(\App\Businesses\BusinessState::class)->isRole($user))
                        <div class="user-vip">
                            <div class="vip-logo">
                                <img src="/images/icons/member/vip-logo-hover.png" width="100" height="100">
                            </div>
                            <div class="vip-logo-text">
                                {{$user['role']['name']}} {{\Carbon\Carbon::parse($user['role_expired_at'])->format('Y-m-d')}}
                                到期
                            </div>
                            <div class="vip-option">
                                <a href="{{route('role.index')}}" class="vip-option-button">立即续费</a>
                            </div>
                        </div>
                    @else
                        <div class="user-vip">
                            <div class="vip-logo">
                                <img src="/images/icons/member/vip-logo-hover.png" width="100" height="100">
                            </div>
                            <div class="vip-logo-text">
                                您还未成为本站会员哦
                            </div>
                            <div class="vip-option">
                                <a href="{{route('role.index')}}" class="vip-option-button">成为会员</a>
                            </div>
                        </div>
                    @endif
                    <div class="user-socialite">
                        <div class="alert-info">
                            绑定第三方账号更方便快捷登录和数据同步哦！
                        </div>
                        <div class="option-item">
                            <div class="option-text">绑定手机</div>
                            @if(app()->make(\App\Businesses\BusinessState::class)->isNeedBindMobile($user))
                                <div class="option-value">未绑定</div>
                                <div class="option-button" onclick="showAuthBox('mobile-bind-box')">绑定</div>
                            @else
                                <div class="option-value">{{substr($user['mobile'], 0, 3) . '****' . substr($user['mobile'], -4, 4)}}</div>
                            @endif
                        </div>
                        @foreach(enabled_socialites() as $app)
                            <div class="option-item">
                                <div class="option-text">{{$app['name']}}</div>
                                @if(isset($apps[$app['app']]))
                                    <div class="option-value">已绑定</div>
                                    <div class="option-button"
                                         onclick="document.getElementById('delete-socialite-{{$app['app']}}').submit();">
                                        取绑
                                    </div>
                                    <form id="delete-socialite-{{$app['app']}}"
                                          action="{{route('member.socialite.delete', [$app['app']])}}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                @else
                                    <div class="option-value">未绑定</div>
                                    <a target="_blank" href="{{route('socialite', [$app['app']])}}"
                                       class="option-button">绑定</a>
                                @endif
                            </div>
                        @endforeach
                        <div class="option-item">
                            <div class="option-text">修改密码</div>
                            <div class="option-value">{{$user['is_password_set'] ? '已设置' : '未设置'}}</div>
                            <a href="javascript:void(0);" class="option-button"
                               onclick="showAuthBox('password-change')">修改</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script id="mobile-bind-box" type="text/html">
        <form class="login-box" action="{{route('ajax.mobile.bind')}}" method="post">
            <div class="login-box-title" style="margin-bottom: 30px;">
                <span class="title">手机号绑定</span>
                <img src="/images/close.png" width="24" height="24" class="close-auth-box">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="mobile" placeholder="请输入手机号">
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="captcha" placeholder="验证码" class="form-control" required>
                    <div class="input-group-append">
                        <img src="{{ captcha_src() }}" class="captcha" width="120" height="36">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="sms_captcha" placeholder="手机验证码" class="form-control" required>
                    <input type="hidden" name="sms_captcha_key" value="mobile_bind">
                    <div class="input-group-append">
                        <button type="button" style="width: 120px;"
                                class="send-sms-captcha btn btn-outline-primary">发送验证码
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group auth-box-errors"></div>
            <div class="form-group mb-0">
                <button type="button" class="btn btn-primary btn-block mobile-bind-button">立即绑定</button>
            </div>
        </form>
    </script>

    <script id="password-change" type="text/html">
        <form class="login-box" action="{{route('ajax.password.change')}}" method="post">
            <div class="login-box-title" style="margin-bottom: 30px;">
                <span class="title">修改密码</span>
                <img src="/images/close.png" width="24" height="24" class="close-auth-box">
            </div>
            @if($user['is_password_set'])
                <div class="form-group">
                    <input type="password" placeholder="请输入原密码" name="old_password" class="form-control"
                           required>
                </div>
            @endif
            <div class="form-group">
                <input type="password" placeholder="请输入新密码" name="new_password" class="form-control"
                       required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="再输入一次" name="new_password_confirmation"
                       class="form-control" required>
            </div>
            <div class="form-group auth-box-errors"></div>
            <div class="form-group mb-0">
                <button type="button" class="btn btn-primary btn-block password-change-button">修改密码</button>
            </div>
        </form>
    </script>

    <script id="nickname-change" type="text/html">
        <form class="login-box" action="{{route('ajax.nickname.change')}}" method="post">
            <div class="login-box-title" style="margin-bottom: 30px;">
                <span class="title">修改昵称</span>
                <img src="/images/close.png" width="24" height="24" class="close-auth-box">
            </div>
            <div class="form-group">
                <input type="text" placeholder="请输入昵称" name="nick_name" class="form-control"
                       required>
            </div>
            <div class="form-group auth-box-errors"></div>
            <div class="form-group mb-0">
                <button type="button" class="btn btn-primary btn-block nickname-change-button">确认修改</button>
            </div>
        </form>
    </script>

    <script id="avatar-change" type="text/html">
        <form class="login-box" action="{{route('ajax.avatar.change')}}" method="post">
            <div class="login-box-title" style="margin-bottom: 30px;">
                <span class="title">更换头像</span>
                <img src="/images/close.png" width="24" height="24" class="close-auth-box">
            </div>
            <div class="alert alert-primary">
                <p class="mb-0">1.支持png,jpg,gif图片格式。</p>
                <p class="mb-0">2.图片大小不能超过1MB。</p>
            </div>
            <div class="form-group">
                <label>选择头像文件</label><br>
                <input type="file" name="file">
            </div>
            <div class="form-group auth-box-errors"></div>
            <div class="form-group mb-0">
                <button type="button" class="btn btn-primary btn-block avatar-change-button">确认更换</button>
            </div>
        </form>
    </script>

@endsection