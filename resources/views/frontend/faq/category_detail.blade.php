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
        <div class="col-sm-12">
            <nav class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('faq')}}">FAQ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
            </nav>
        </div>
        <div class="col-sm-3">
            <ul class="list-group">
                @foreach($categories as $item)
                <li class="list-group-item {{$item->id == $category->id ? 'active' : ''}}">
                    <a href="{{route('faq.category.show', $item)}}">{{$item->name}}</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-9">
            <ul class="faq-body-list-box">
                @forelse($articles as $article)
                <li>
                    <a href="{{route('faq.article.show', $article)}}">{{$article->title}}</a>
                    <span class="float-right color-gray">编辑于：{{$article->updated_at->diffForHumans()}}</span>
                </li>
                @empty
                    <li><p class="lh-30 text-center color-gray">暂无数据</p></li>
                @endforelse
            </ul>
            <div class="text-right">{{$articles->render()}}</div>
        </div>
    </div>
</div>

@endsection