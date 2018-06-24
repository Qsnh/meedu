@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑角色'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.administrator_role.index') }}'" :name="'返回角色列表'"></meedu-a>
        </el-col>
        <el-col :span="12" :offset="6">
            <el-form label-position="top" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <el-form-item label="Slug">
                    <el-input name="slug" value="{{ $role->slug }}" disabled></el-input>
                </el-form-item>
                <el-form-item label="角色名">
                    <el-input name="display_name" value="{{ $role->display_name }}" placeholder="请输入角色名"></el-input>
                </el-form-item>
                <el-form-item label="描述">
                    <el-input name="description" value="{{ $role->description }}" placeholder="请输入描述"></el-input>
                </el-form-item>
                <el-button type="primary" native-type="submit">编辑</el-button>
            </el-form>
        </el-col>
    </el-row>

@endsection