@extends('layouts.backend')

@section('title')
    添加推广链接
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.adfrom.index') }}" class="btn btn-primary">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>推广链接名 @include('components.backend.required')</label>
                    <input type="text" name="from_name" class="form-control" placeholder="推广链接名" required>
                </div>
                <div class="form-group">
                    <label>推广链接特征值 @include('components.backend.required')</label>
                    <input type="text" name="from_key" class="form-control" placeholder="推广链接特征值" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">创建</button>
                </div>
            </form>
        </div>
    </div>

@endsection