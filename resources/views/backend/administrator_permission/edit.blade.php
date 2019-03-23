@extends('layouts.backend')

@section('title')
    编辑权限
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.administrator_permission.index') }}" class="btn btn-primary">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label>权限名 @include('components.backend.required')</label>
                    <input type="text" name="display_name" value="{{$permission->display_name}}" class="form-control" placeholder="请输入权限名" required>
                </div>
                <div class="form-group">
                    <label>Slug @include('components.backend.required')</label>
                    <input type="text" name="slug" value="{{$permission->slug}}" class="form-control" placeholder="请输入Slug" required>
                </div>
                <div class="form-group">
                    <label>描述  @include('components.backend.required')</label>
                    <input type="text" name="description" value="{{$permission->description}}" class="form-control" placeholder="请输入描述" required>
                </div>
                <div class="form-group">
                    <label>请求方式  @include('components.backend.required')</label>
                    <select name="method[]" class="form-control" multiple>
                        <option value="GET" {{in_array('GET', $permission->getMethodArray()) ? 'selected' : ''}}>GET</option>
                        <option value="POST" {{in_array('POST', $permission->getMethodArray()) ? 'selected' : ''}}>POST</option>
                        <option value="PUT" {{in_array('PUT', $permission->getMethodArray()) ? 'selected' : ''}}>PUT</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>请求地址[支持正则表达式]  @include('components.backend.required')</label>
                    <input type="text" name="url" value="{{$permission->url}}" class="form-control" placeholder="请求地址[支持正则表达式]" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>

@endsection