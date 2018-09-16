@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '主面板'])

    <el-row>
        <el-col :span="24" class="backend-dashboard-banner">
            <h3 style="line-height: 60px">欢迎使用 MeEdu 在线教育点播系统。在这里，您可以开展自己的在线教育。</h3>
            <p style="color: gray">MeEdu 是一套开源，免费的系统，您可以无限制的使用它而不用担心任何版权问题！</p>
        </el-col>
    </el-row>

@endsection

@include('components.vue_init')
