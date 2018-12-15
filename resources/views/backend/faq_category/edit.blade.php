@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑FAQ分类'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.faq.category.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label>排序值（整数，升序） @include('components.backend.required')</label>
                    <input type="text" name="sort" class="form-control" placeholder="排序值（整数，升序）" value="{{$category->sort}}" required>
                </div>
                <div class="form-group">
                    <label>分类名 @include('components.backend.required')</label>
                    <input type="text" name="name" class="form-control" placeholder="分类名" value="{{$category->name}}" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </form>
        </div>
    </div>

@endsection