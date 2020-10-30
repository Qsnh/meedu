@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '我的积分', 'back' => route('member')])

    <div class="member-credit1-page">
        @forelse($records as $record)
            <div class="credit1-item">
                <div class="title">{{$record['remark']}}</div>
                <div class="sum">{{$record['sum'] > 0 ? '+' : ''}}{{$record['sum']}}</div>
            </div>
        @empty
            @include('h5.components.none')
        @endforelse

        @if($records->total() > $records->perPage())
            <div class="box">
                {!! str_replace('pagination', 'pagination justify-content-center', $records->render('pagination::simple-bootstrap-4')) !!}
            </div>
        @endif
    </div>

@endsection