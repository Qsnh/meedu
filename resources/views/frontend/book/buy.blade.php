@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 recharge-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>购买电子书</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container all-buy-box">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <h3 style="line-height: 100px;" class="text-center">你正在购买电子书《{{$book->title}}》</h3>
                <ul class="list-group">
                    <p>章节如下</p>
                    @foreach($book->showAndPublishedChapter() as $chapter)
                        <li class="list-group-item">{{$chapter->title}}</li>
                    @endforeach
                </ul>

                <div style="margin-top: 15px;">
                    <h1 class="text-center">￥{{$book->charge}}</h1>
                    <form action="" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">立即购买</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection