@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加友情链接'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.link.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>排序</label>
                    <input type="text" name="sort" class="form-control" placeholder="排序（升序）">
                </div>
                <div class="form-group">
                    <label>链接名</label>
                    <input type="text" name="name" class="form-control" placeholder="链接名">
                </div>
                <div class="form-group">
                    <label>链接地址</label>
                    <input type="text" name="url" class="form-control" placeholder="链接地址">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">创建</button>
                </div>
            </form>
        </div>
    </div>

@endsection