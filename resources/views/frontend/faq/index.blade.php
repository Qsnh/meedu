@extends('layouts.app')

@section('content')

    <div class="container-fluid faq-banner">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h1>帮助中心</h1>
            </div>
        </div>
    </div>

    <div class="container faq-body">
        <div class="row">
            @forelse($categories as $category)
            <div class="col-sm-4" style="margin-top: 15px;">
                <div class="card">
                    <div class="card-header text-center">
                        <a href="{{route('faq.category.show', $category)}}">{{$category->name}}</a>
                    </div>
                    <div class="card-body">
                        <ul>
                            @foreach($category->articles()->orderByDesc('updated_at')->limit(5)->get() as $article)
                                <li class="lh-30"><a href="{{route('faq.article.show', $article)}}">{{$article->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-sm-12">
                    <p class="color-gray lh-30 text-center">暂无数据</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection