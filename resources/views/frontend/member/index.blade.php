@extends('layouts.member')

@section('content')
    <h3>Hi.{{ Auth::user()->nick_name }}.</h3>
@endsection