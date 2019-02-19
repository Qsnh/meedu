@extends('layouts.member')

@section('member')

    <div class="row">
        <h3>已购电子书</h3>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <td>电子书</td>
        </tr>
        </thead>
        <tbody>
        @forelse($books as $book)
            <tr>
                <td><a href="{{route('book.show', $book)}}">{{$book->title}}</a></td>
            </tr>
        @empty
            <tr>
                <td class="text-center color-gray" colspan="1">暂无数据</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="text-right">
        {{$books->render()}}
    </div>
@endsection