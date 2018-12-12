@extends('layouts.backend')

@section('body')

@include('components.breadcrumb', ['name' => '编辑首页导航'])

<div class="row row-cards">
    <div class="col-sm-12">
        <a href="{{ route('backend.nav.index') }}" class="btn btn-primary ml-auto">返回列表</a>
    </div>
    <div class="col-sm-12">
        <form action="" method="post">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
    <label>排序值</label>
    <input type="text" name="sort" value="{{$one->sort}}" class="form-control" placeholder="排序值">
</div>
<div class="form-group">
    <label>链接名</label>
    <input type="text" name="name" value="{{$one->name}}" class="form-control" placeholder="链接名">
</div>
<div class="form-group">
    <label>链接地址</label>
    <input type="text" name="url" value="{{$one->url}}" class="form-control" placeholder="链接地址">
</div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">保存</button>
            </div>
        </form>
    </div>
</div>

@endsection