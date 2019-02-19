@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '添加电子书'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.book.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <label>书名 @include('components.backend.required')</label>
                    <input type="text" name="title" value="{{old('title')}}" class="form-control" placeholder="请输入书名" required>
                </div>
                <div class="form-group">
                    <label>描述 @include('components.backend.required')</label>
                    @include('components.backend.editor', ['name' => 'description'])
                </div>
                <div class="form-group">
                    <label>一句话描述 @include('components.backend.required')</label>
                    <textarea name="short_description" class="form-control" rows="2" placeholder="简短介绍" required></textarea>
                </div>
                @include('components.backend.image', ['name' => 'thumb', 'title' => '封面'])
                <div class="form-group">
                    <label>上架时间 @include('components.backend.required')</label>
                    @include('components.backend.datetime', ['name' => 'published_at'])
                </div>
                <div class="form-group">
                    <label>是否显示 @include('components.backend.required')</label><br>
                    <label><input type="radio" name="is_show" value="{{ \App\Models\Book::SHOW_YES }}" checked>是</label>
                    <label><input type="radio" name="is_show" value="{{ \App\Models\Book::SHOW_NO }}">否</label>
                </div>
                <div class="form-group">
                    <label>价格 @include('components.backend.required')</label>
                    <input type="text" name="charge" placeholder="价格" class="form-control" value="{{old('charge')}}" required>
                </div>
                <div class="form-group">
                    <label>SEO关键字 @include('components.backend.required')</label>
                    <textarea name="seo_keywords" class="form-control" rows="2" placeholder="SEO关键字" required></textarea>
                </div>
                <div class="form-group">
                    <label>SEO描述 @include('components.backend.required')</label>
                    <textarea name="seo_description" class="form-control" rows="2" placeholder="SEO描述" required></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">创建</button>
                </div>
            </form>
        </div>
    </div>

@endsection