@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑FAQ文章'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.faq.article.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label>分类 @include('components.backend.required')</label>
                    <select name="category_id" class="form-control">
                        <option value="">无</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{$article->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>文章标题 @include('components.backend.required')</label>
                    <input type="text" name="title" class="form-control" placeholder="文章标题" value="{{$article->title}}" required>
                </div>
                <div class="form-group">
                    <label>文章内容 @include('components.backend.required')</label>
                    @include('components.backend.editor', ['name' => 'content', 'content' => $article->content])
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>

@endsection