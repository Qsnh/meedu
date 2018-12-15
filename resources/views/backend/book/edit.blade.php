@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑电子书'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.book.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label>书名 @include('components.backend.required')</label>
                    <input type="text" name="title" value="{{$book->title}}" class="form-control" placeholder="请输入书名" required>
                </div>
                <div class="form-group">
                    <label>描述 @include('components.backend.required')</label>
                    @include('components.backend.editor', ['name' => 'description', 'content' => $book->description])
                </div>
                <div class="form-group">
                    <label>一句话描述 @include('components.backend.required')</label>
                    <textarea name="short_description" class="form-control"
                              rows="2" placeholder="简短介绍" required>{{$book->short_description}}</textarea>
                </div>
                @include('components.backend.image', ['name' => 'thumb', 'title' => '封面', 'value' => $book->thumb])
                <div class="form-group">
                    <label>上架时间 @include('components.backend.required')</label>
                    @include('components.backend.datetime', ['name' => 'published_at', 'value' => $book->published_at])
                </div>
                <div class="form-group">
                    <label>是否显示 @include('components.backend.required')</label><br>
                    <label><input type="radio" name="is_show"
                                  value="{{ \App\Models\Book::SHOW_YES }}"
                                {{$book->is_show == \App\Models\Book::SHOW_YES ? 'checked' : ''}}>是</label>
                    <label><input type="radio" name="is_show"
                                  value="{{ \App\Models\Book::SHOW_NO }}"
                                {{$book->is_show == \App\Models\Book::SHOW_NO ? 'checked' : ''}}>否</label>
                </div>
                <div class="form-group">
                    <label>价格 @include('components.backend.required')</label>
                    <input type="text" name="charge" placeholder="价格" class="form-control" value="{{$book->charge}}" required>
                </div>
                <div class="form-group">
                    <label>SEO关键字 @include('components.backend.required')</label>
                    <textarea name="seo_keywords" class="form-control" rows="2" placeholder="SEO关键字" required>{{$book->seo_keywords}}</textarea>
                </div>
                <div class="form-group">
                    <label>SEO描述 @include('components.backend.required')</label>
                    <textarea name="seo_description" class="form-control" rows="2" placeholder="SEO描述" required>{{$book->seo_description}}</textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>

@endsection