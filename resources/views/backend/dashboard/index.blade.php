@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '主面板'])

    <el-row class="backend-dashboard-banner text-center">
        <el-col span="8">
            <h1>今日注册</h1>
            <h3>{{$todayRegisterUserCount}} <small>位</small></h3>
        </el-col>
        <el-col span="8">
            <h1>今日充值</h1>
            <h3>{{$todayRechargeCount}} <small>单</small></h3>
        </el-col>
        <el-col span="8">
            <h1>今日充值</h1>
            <h3>{{$todayRechargeSum}} <small>元</small></h3>
        </el-col>
    </el-row>

@endsection

@section('js')
@include('components.vue_init')
@endsection