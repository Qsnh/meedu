@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加FAQ文章'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.faq.article.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>分类</label>
                    <select name="category_id" class="form-control">
                        <option value="">无</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>文章标题</label>
                    <input type="text" name="title" class="form-control" placeholder="文章标题" value="{{old('title')}}">
                </div>
                <div class="form-group">
                    <label>文章内容</label>
                    @include('components.backend.editor', ['name' => 'content'])
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">创建</button>
                </div>
            </form>
        </div>
    </div>

@endsection