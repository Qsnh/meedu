@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加管理员'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.administrator.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label>姓名</label>
                    <input type="text" name="name" class="form-control" placeholder="请输入姓名" value="{{$administrator->name}}">
                </div>
                <div class="form-group">
                    <label>邮箱</label>
                    <input type="text" name="email" class="form-control" placeholder="请输入邮箱" value="{{$administrator->email}}" disabled="disabled">
                </div>
                <div class="form-group">
                    <label>密码(可选)</label>
                    <input type="password" name="password" class="form-control" placeholder="请输入密码">
                </div>
                <div class="form-group">
                    <label>请再输入一次密码</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="请再输入一次密码">
                </div>
                <div class="form-group">
                    <label>角色</label>
                    <select name="role_id[]" multiple="multiple" class="form-control">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{$role->hasAdministrator($administrator) ? 'selected' : ''}}>{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>

@endsection