@extends('layouts.backend')

@section('title')
    编辑首页导航
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.nav.index') }}" class="btn btn-primary">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label>排序值 @include('components.backend.required')</label>
                    <input type="text" name="sort" value="{{$one->sort}}" class="form-control" placeholder="排序值" required>
                </div>
                <div class="form-group">
                    <label>链接名 @include('components.backend.required')</label>
                    <input type="text" name="name" value="{{$one->name}}" class="form-control" placeholder="链接名" required>
                </div>
                <div class="form-group">
                    <label>链接地址 @include('components.backend.required')</label>
                    <input type="text" name="url" value="{{$one->url}}" class="form-control" placeholder="链接地址" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>

@endsection