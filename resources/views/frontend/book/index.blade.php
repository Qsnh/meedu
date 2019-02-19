@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 course-index-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>电子书</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container book-list-box mb-15 mt-15">
        <div class="row">
            @foreach($books as $book)
                <div class="col-sm-4">
                    <div class="card mt-15 mb-15">
                        <img class="card-img-top" style="height: 300px;" src="{{$book->thumb}}" alt="{{$book->title}}">
                        <div class="card-body">
                            <h5 class="card-title">{{$book->title}}</h5>
                            <p class="card-text">{{$book->short_description}}</p>
                            <a href="{{route('book.show', $book)}}" class="btn btn-primary">阅读</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="Page navigation">
                    {{$books->render()}}
                </nav>
            </div>
        </div>

    </div>

@endsection