@extends('layouts.h5-pure')

@section('css')
<style>
.box {
    box-sizing: border-box;
    padding: 15px;
}
</style>
@endsection

@section('content')

    <div class="box">
        <h3 class="title mb-3">{{$a['title']}}</h3>
        <div class="content">
            {!! $a['announcement'] !!}
        </div>
    </div>

@endsection