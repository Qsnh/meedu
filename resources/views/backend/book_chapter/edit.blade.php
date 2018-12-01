@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '编辑章节'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.book.chapter.index', [$book->id]) }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="book_id" value="{{$chapter->book_id}}">
                <div class="form-group">
                    <label>章节名</label>
                    <input type="text" name="title" class="form-control" placeholder="请输入章节名" value="{{$chapter->title}}">
                </div>
                <div class="form-group">
                    <label>内容</label>
                    @include('components.backend.editor', ['name' => 'content', 'content' => $chapter->content])
                </div>
                <div class="form-group">
                    <label>是否显示</label><br>
                    <label><input type="radio" name="is_show"
                                  value="{{ \App\Models\BookChapter::SHOW_YES }}"
                                {{$chapter->is_show == \App\Models\BookChapter::SHOW_YES ? 'checked' : ''}}> 是</label>
                    <label><input type="radio" name="is_show"
                                  value="{{ \App\Models\BookChapter::SHOW_NO }}"
                                {{$chapter->is_show == \App\Models\BookChapter::SHOW_NO ? 'checked' : ''}}> 否</label>
                </div>
                <div class="form-group">
                    <label>上架时间</label>
                    @include('components.backend.datetime', ['name' => 'published_at', 'value' => $chapter->published_at])
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">创建</button>
                </div>
            </form>
        </div>
    </div>

@endsection