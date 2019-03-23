@extends('layouts.backend')

@section('title')
    修改密码
@endsection

@section('body')

    <div class="row row-cards justify-content-center">
        <div class="col-sm-4">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label>原密码 @include('components.backend.required')</label>
                    <input type="password" name="old_password" placeholder="请输入原密码" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>新密码 @include('components.backend.required')</label>
                    <input type="password" name="new_password" placeholder="请输入新密码" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>请再输入一次新密码 @include('components.backend.required')</label>
                    <input type="password" name="new_password_confirmation" placeholder="请再输入一次新密码" class="form-control" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">修改密码</button>
                </div>
            </form>
        </div>
    </div>

@endsection