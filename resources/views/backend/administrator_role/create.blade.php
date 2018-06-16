@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加角色'])

    <el-row>
        <el-col :span="24">
            @include('components.button', ['url' => route('backend.administrator_role.index'), 'title' => '返回角色列表'])
        </el-col>
        <el-col :span="12" :offset="6">
            <el-form label-position="top" method="post">
                {!! csrf_field() !!}
                <el-form-item label="角色名">
                    <el-input name="display_name" value="{{ old('display_name') }}" placeholder="请输入角色名"></el-input>
                </el-form-item>
                <el-form-item label="Slug">
                    <el-input name="slug" value="{{ old('slug') }}" placeholder="请输入Slug"></el-input>
                </el-form-item>
                <el-form-item label="描述">
                    <el-input name="description" value="{{ old('description') }}" placeholder="请输入描述"></el-input>
                </el-form-item>
                <el-button type="primary" native-type="submit">添加</el-button>
            </el-form>
        </el-col>
    </el-row>

@endsection