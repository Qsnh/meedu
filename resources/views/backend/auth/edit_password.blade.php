@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '修改密码'])

    <el-row>
        <el-col :span="12" :offset="6">
            <el-form label-position="top" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <el-form-item label="原密码">
                    <el-input name="old_password" type="password" placeholder="请输入原密码"></el-input>
                </el-form-item>
                <el-form-item label="密码">
                    <el-input name="new_password" type="password" placeholder="请输入新密码"></el-input>
                </el-form-item>
                <el-form-item label="请再输入一次密码">
                    <el-input name="new_password_confirmation" type="password" placeholder="请再输入一次新密码">
                    </el-input>
                </el-form-item>
                <el-button type="primary" native-type="submit">修改密码</el-button>
            </el-form>
        </el-col>
    </el-row>

@endsection

@section('js')
    @include('components.vue_init')
@endsection