@extends('layouts.backend')

@section('title')
    添加会员
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.member.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                @include('components.backend.image', ['name' => 'avatar', 'title' => '头像'])
                <div class="form-group">
                    <label>昵称 @include('components.backend.required')</label>
                    <input type="text" name="nick_name" class="form-control" placeholder="昵称" required>
                </div>
                <div class="form-group">
                    <label>手机号 @include('components.backend.required')</label>
                    <input type="text" name="mobile" class="form-control" placeholder="手机号" required>
                </div>
                <div class="form-group">
                    <label>密码 @include('components.backend.required')</label>
                    <input type="text" name="password" class="form-control" placeholder="密码" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">创建</button>
                </div>
            </form>
        </div>
    </div>

@endsection