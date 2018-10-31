@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 course-index-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>《{{$book->title}}》</h3>
                            <p style="line-height: 46px;">
                                <span class="badge badge-primary">
                                    更新于 {{ $book->updated_at->diffForHumans() }}
                                </span>
                                @if($book->charge)
                                    <span class="badge badge-danger">价格 {{$book->charge}}元</span>
                                @else
                                    <span class="badge badge-success">免费</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container book-list-box mb-15 mt-15">
        <div class="row">

            <div class="col-sm-3">
                <ul class="list-group">
                    @foreach($book->showAndPublishedChapter() as $chapterItem)
                        <a href="{{route('member.book.chapter', [$chapterItem->book_id, $chapterItem->id])}}"
                           class="list-group-item {{$chapter->id == $chapterItem->id ? 'active' : ''}}">
                            {{$chapterItem->title}} <small>更新于：{{$chapterItem->updated_at->diffForHumans()}}</small>
                            @if($book->charge > 0)
                                <span class="badge badge-primary">收费</span>
                            @else
                                <span class="badge badge-success">免费</span>
                            @endif
                        </a>
                    @endforeach
                </ul>
            </div>

            <div class="col-sm-9">
                <div class="card">
                    <div class="card-header">{{$chapter->title}}</div>
                    <div class="card-body book-chapter-content">
                        {!! $chapter->getContent() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection