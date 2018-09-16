@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加公告'])

    <el-row>
        <el-col :span="24">
            <meedu-a :url="'{{ route('backend.announcement.index') }}'" :name="'返回公告列表'"></meedu-a>
        </el-col>
        <el-col :span="12" :offset="6">
            <el-form label-position="top" method="post">
                {!! csrf_field() !!}
                <el-form-item label="公告内容">
                    <meedu-markdown :markdown="''" field="announcement"></meedu-markdown>
                </el-form-item>
                <el-button type="primary" native-type="submit">添加</el-button>
            </el-form>
        </el-col>
    </el-row>

@endsection

@include('components.vue_init')