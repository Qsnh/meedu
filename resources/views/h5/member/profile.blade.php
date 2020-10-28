@extends('layouts.h5-pure')

@section('content')

    <div class="top-navbar {{$class ?? ''}}">
        <a href="javascript:void(0)" class="back back-button" data-url="{{route('member')}}">
            <img src="{{asset('/h5/images/icons/back.png')}}" width="24" height="24">
        </a>
        <span class="title">用户资料</span>
        <div class="right-menus">
            <a href="javascript:void(0)" class="save-profile-button" data-url="{{route('ajax.member.profile.update')}}">保存</a>
        </div>
    </div>

    <div class="member-profile-box">
        <div class="profile-item">
            <div class="name">姓名</div>
            <div class="value">
                <input type="text" name="real_name" value="{{$profile['real_name'] ?? ''}}" placeholder="真实姓名">
            </div>
        </div>
        <div class="profile-item">
            <div class="name">性别</div>
            <div class="value">
                <label><input type="radio" name="gender"
                              value="男" {{($profile['gender'] ?? '') === '男' ? 'checked' : ''}}>男</label>
                <label><input type="radio" name="gender"
                              value="女" {{($profile['gender'] ?? '') === '女' ? 'checked' : ''}}>女</label>
            </div>
        </div>
        <div class="profile-item">
            <div class="name">年龄</div>
            <div class="value">
                <input type="text" name="age" value="{{$profile['age'] ?? ''}}" placeholder="如：21">
            </div>
        </div>
        <div class="profile-item">
            <div class="name">生日</div>
            <div class="value">
                <input type="text" name="birthday" value="{{$profile['birthday'] ?? ''}}" placeholder="格式：19901010">
            </div>
        </div>
        <div class="profile-item">
            <div class="name">职业</div>
            <div class="value">
                <input type="text" name="profession" value="{{$profile['profession'] ?? ''}}" placeholder="职业">
            </div>
        </div>
        <div class="profile-item">
            <div class="name">住址</div>
            <div class="value">
                <input type="text" name="address" value="{{$profile['address'] ?? ''}}" placeholder="住址">
            </div>
        </div>
    </div>

    <div class="member-profile-box">
        <div class="profile-item">
            <div class="name">毕业院校</div>
            <div class="value">
                <input type="text" name="graduated_school" value="{{$profile['graduated_school'] ?? ''}}"
                       placeholder="毕业院校">
            </div>
        </div>
        <div class="profile-image-item">
            <div class="name">毕业证照片</div>
            <div class="value">
                <input type="hidden" name="diploma" value="{{$profile['diploma'] ?? ''}}">
                <div style="display: none">
                    <input type="file" id="file-diploma" accept="image/*" capture>
                </div>
                <div class="image img-diploma">
                    @if($profile['diploma'] ?? '')
                        <img src="{{$profile['diploma']}}" width="100" height="100">
                    @endif
                </div>
                <div class="image upload-image-button" data-view-id="img-diploma" data-url="{{route('upload.image')}}"
                     data-file-id="file-diploma" data-input="diploma"
                     style="background-image: url('{{asset('/images/icons/uploadImage.png')}}')">
                </div>
            </div>
        </div>
    </div>

    <div class="member-profile-box">
        <div class="profile-item">
            <div class="name">身份证号码</div>
            <div class="value">
                <input type="text" name="id_number" value="{{$profile['id_number'] ?? ''}}"
                       placeholder="身份证号码">
            </div>
        </div>
        <div class="profile-image-item">
            <div class="name">身份证正面</div>
            <div class="value">
                <input type="hidden" name="id_frontend_thumb" value="{{$profile['id_frontend_thumb'] ?? ''}}">
                <div style="display: none">
                    <input type="file" id="file-id_frontend_thumb" accept="image/*" capture>
                </div>
                <div class="image img-id_frontend_thumb">
                    @if($profile['id_frontend_thumb'] ?? '')
                        <img src="{{$profile['id_frontend_thumb']}}" width="100" height="100">
                    @endif
                </div>
                <div class="image upload-image-button" data-view-id="img-id_frontend_thumb"
                     data-url="{{route('upload.image')}}"
                     data-file-id="file-id_frontend_thumb" data-input="id_frontend_thumb"
                     style="background-image: url('{{asset('/images/icons/uploadImage.png')}}')">
                </div>
            </div>
        </div>
        <div class="profile-image-item">
            <div class="name">身份证反面</div>
            <div class="value">
                <input type="hidden" name="id_backend_thumb" value="{{$profile['id_backend_thumb'] ?? ''}}">
                <div style="display: none">
                    <input type="file" id="file-id_backend_thumb" accept="image/*" capture>
                </div>
                <div class="image img-id_backend_thumb">
                    @if($profile['id_backend_thumb'] ?? '')
                        <img src="{{$profile['id_backend_thumb']}}" width="100" height="100">
                    @endif
                </div>
                <div class="image upload-image-button" data-view-id="img-id_backend_thumb"
                     data-url="{{route('upload.image')}}"
                     data-file-id="file-id_backend_thumb" data-input="id_backend_thumb"
                     style="background-image: url('{{asset('/images/icons/uploadImage.png')}}')">
                </div>
            </div>
        </div>
        <div class="profile-image-item">
            <div class="name">手持身份证照</div>
            <div class="value">
                <input type="hidden" name="id_hand_thumb" value="{{$profile['id_hand_thumb'] ?? ''}}">
                <div style="display: none">
                    <input type="file" id="file-id_hand_thumb" accept="image/*" capture>
                </div>
                <div class="image img-id_hand_thumb">
                    @if($profile['id_hand_thumb'] ?? '')
                        <img src="{{$profile['id_hand_thumb']}}" width="100" height="100">
                    @endif
                </div>
                <div class="image upload-image-button" data-view-id="img-id_hand_thumb"
                     data-url="{{route('upload.image')}}"
                     data-file-id="file-id_hand_thumb" data-input="id_hand_thumb"
                     style="background-image: url('{{asset('/images/icons/uploadImage.png')}}')">
                </div>
            </div>
        </div>
    </div>

@endsection