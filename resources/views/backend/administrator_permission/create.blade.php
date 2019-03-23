@extends('layouts.backend')

@section('title')
    添加权限
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.administrator_permission.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>权限名 @include('components.backend.required')</label>
                    <input type="text" name="display_name" class="form-control" placeholder="请输入权限名" required>
                </div>
                <div class="form-group">
                    <label>Slug @include('components.backend.required')</label>
                    <input type="text" name="slug" class="form-control" placeholder="请输入Slug" required>
                </div>
                <div class="form-group">
                    <label>描述 @include('components.backend.required')</label>
                    <input type="text" name="description" class="form-control" placeholder="请输入描述" required>
                </div>
                <div class="form-group">
                    <label>请求方式 @include('components.backend.required')</label>
                    <select name="method[]" class="form-control" multiple>
                        <option value="GET">GET</option>
                        <option value="POST">POST</option>
                        <option value="PUT">PUT</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>请求地址[支持正则表达式] @include('components.backend.required')</label>
                    <input type="text" name="url" class="form-control" placeholder="请求地址[支持正则表达式]" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">创建</button>
                </div>
            </form>
        </div>
    </div>

@endsection