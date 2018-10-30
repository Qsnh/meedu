@extends('layouts.app')

@section('css')
    <link href="https://lib.baomitu.com/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
@endsection

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
            <div class="col-sm">
                <div class="card">
                    <div class="card-body">
                        <div class="social-share"></div>
                        <hr>
                        <ul class="list-group">
                            @foreach($book->showAndPublishedChapter() as $chapter)
                            <a href="" class="list-group-item">
                                {{$chapter->title}} <small>更新于：{{$chapter->updated_at->diffForHumans()}}</small>
                                @if($book->charge > 0)
                                    <span class="badge badge-primary">收费</span>
                                @else
                                    <span class="badge badge-success">免费</span>
                                @endif
                            </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://lib.baomitu.com/social-share.js/1.0.16/js/social-share.min.js"></script>
    @include('components.frontend.emoji')
@endsection