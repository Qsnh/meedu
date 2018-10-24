@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '创建邮件群发'])

    <el-row :gutter="20">
        @component('components.backend.warning')
            所有订阅过本站的邮箱都将收到邮件！
        @endcomponent
        <el-form label-position="top" method="post">
            {!! csrf_field() !!}
            <el-col :span="12" :offset="6">
                <el-form-item label="邮件标题">
                    <el-input name="title" placeholder="邮件标题" value="{{ old('title') }}"></el-input>
                </el-form-item>

                <el-form-item label="邮件内容">
                    <meedu-markdown :markdown="''" field="content"></meedu-markdown>
                </el-form-item>

                <el-form-item>
                    <el-button native-type="submit" type="primary" native-button="submit">开始群发</el-button>
                </el-form-item>
            </el-col>
        </el-form>
    </el-row>

@endsection

@section('js')
    @include('components.vue_init')
@endsection