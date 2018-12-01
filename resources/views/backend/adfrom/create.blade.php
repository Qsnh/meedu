@extends('layouts.backend')

@section('body')

@include('components.breadcrumb', ['name' => '添加推广链接'])

<div class="row row-cards">
    <div class="col-sm-12">
        <a href="{{ route('backend.adfrom.index') }}" class="btn btn-primary ml-auto">返回列表</a>
    </div>
    <div class="col-sm-12">
        <form action="" method="post">
            @csrf
            <div class="form-group">
    <label>推广链接名</label>
    <input type="text" name="from_name" class="form-control" placeholder="推广链接名">
</div>
<div class="form-group">
    <label>推广链接特征值</label>
    <input type="text" name="from_key" class="form-control" placeholder="推广链接特征值">
</div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">创建</button>
            </div>
        </form>
    </div>
</div>

@endsection