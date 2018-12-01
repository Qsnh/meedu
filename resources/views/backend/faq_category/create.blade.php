@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加FAQ分类'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.faq.category.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>排序值（整数，升序）</label>
                    <input type="text" name="sort" class="form-control" placeholder="排序值（整数，升序）" value="{{old('sort')}}">
                </div>
                <div class="form-group">
                    <label>分类名</label>
                    <input type="text" name="name" class="form-control" placeholder="分类名" value="{{old('name')}}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">创建</button>
                </div>
            </form>
        </div>
    </div>

@endsection