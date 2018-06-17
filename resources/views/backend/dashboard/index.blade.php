@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '主面板'])

    <el-row style="text-align: center">
        <el-col :span="6">
            <h1>今日会员</h1>
            <h3>125</h3>
        </el-col>
        <el-col :span="6">
            <h1>今日浏览量</h1>
            <h3>125</h3>
        </el-col>
        <el-col :span="6">
            <h1>今日充值</h1>
            <h3>125</h3>
        </el-col>
        <el-col :span="6">
            <h1>今日文章</h1>
            <h3>125</h3>
        </el-col>
    </el-row>

@endsection