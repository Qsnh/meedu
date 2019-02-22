@extends('layouts.member')

@section('member')

    <div class="row">
        <h3>第三方账号绑定</h3>
    </div>

    <div class="row">
        <div class="col-sm-12 mt-3 mb-3">
            @foreach(enabled_socialites() as $socialite)
            <a href="{{route('socialite', $socialite['app'])}}" class="btn btn-primary btn-sm">
                绑定 {!! $socialite['icon'] ?? '' !!} {{$socialite['name']}}
            </a>
            @endforeach
        </div>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <td>应用</td>
            <td>绑定时间</td>
        </tr>
        </thead>
        <tbody>
        @forelse($apps as $app)
            <tr>
                <td>{{$app->app}}</td>
                <td>{{$app->created_at}}</td>
            </tr>
        @empty
            <tr>
                <td class="text-center color-gray" colspan="2">暂无数据</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection