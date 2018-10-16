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
                    <li class="breadcrumb-item"><a href="{{route('faq.category.show', $article->category)}}">{{$article->category->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$article->title}}</li>
                </nav>
            </div>
            <div class="col-sm-3">
                <ul class="list-group">
                    @foreach($categories as $item)
                        <li class="list-group-item {{$item->id == $article->category->id ? 'active' : ''}}">
                            <a href="{{route('faq.category.show', $item)}}">{{$item->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-9 article-box">
                <h2>{{$article->title}}</h2>
                <p class="color-gray lh-30">
                    <span>编辑于：{{$article->updated_at->diffForHumans()}}</span>
                    <span>编辑人：{{$article->admin ? $article->admin->name : '系统'}}</span>
                </p>
                {!! $article->getContent() !!}
            </div>
        </div>
    </div>

@endsection