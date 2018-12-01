@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => 'FAQ文章'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.faq.article.create') }}" class="btn btn-primary ml-auto">添加</a>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>分类</th>
                    <th>标题</th>
                    <th>最后编辑时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($articles as $article)
                <tr>
                    <td>{{$article->id}}</td>
                    <td>{{$article->category->name}}</td>
                    <td>{{$article->title}}</td>
                    <td>{{$article->updated_at}}</td>
                    <td>
                        <a href="{{route('backend.faq.article.edit', $article)}}" class="btn btn-warning btn-sm">编辑</a>
                        @include('components.backend.destroy', ['url' => route('backend.faq.article.destroy', $article)])
                    </td>
                </tr>
                    @empty
                <tr>
                    <td class="text-center" colspan="5">暂无记录</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-sm-12">
            {{$articles->render()}}
        </div>
    </div>

@endsection