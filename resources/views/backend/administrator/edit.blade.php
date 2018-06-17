@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑管理员'])

    <el-row>
        <el-col :span="24">
            @include('components.button', ['url' => route('backend.administrator.index'), 'title' => '返回管理员列表'])
        </el-col>
        <el-col :span="12" :offset="6">
            <el-form label-position="top" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <el-form-item label="邮箱">
                    <el-input name="email" value="{{ $administrator->email }}" placeholder="请输入邮箱" disabled></el-input>
                </el-form-item>
                <el-form-item label="姓名">
                    <el-input name="name" value="{{ $administrator->name }}" placeholder="请输入姓名"></el-input>
                </el-form-item>
                <el-form-item label="密码(不修改请不要填写)">
                    <el-input name="password" type="password" placeholder="请输入密码"></el-input>
                </el-form-item>
                <el-form-item label="请再输入一次密码">
                    <el-input name="password_confirmation" type="password" placeholder="请再输入一次密码"></el-input>
                </el-form-item>
                <el-form-item label="角色">
                    <select name="role_id[]" multiple="multiple">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $administrator->hasRole($role) ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                </el-form-item>
                <el-button type="primary" native-type="submit">编辑</el-button>
            </el-form>
        </el-col>
    </el-row>

@endsection