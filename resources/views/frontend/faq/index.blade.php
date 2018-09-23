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
            @foreach($categories as $category)
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <a href="{{route('faq.category.show', $category)}}">{{$category->name}}</a>
                    </div>
                    <div class="panel-body">
                        <ul>
                            @foreach($category->articles()->orderByDesc('updated_at')->limit(5)->get() as $article)
                                <li><a href="{{route('faq.article.show', $article)}}">{{$article->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

@endsection