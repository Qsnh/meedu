@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">快捷登录</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="text-center">
                            <tr>
                                <td>应用</td>
                                <td>绑定时间</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($enabledApps as $app)
                                <tr class="text-center">
                                    <td>{{$app['app']}}</td>
                                    <td>
                                        @if(isset($apps[$app['app']]))
                                            <span class="mr-2">已绑定</span>
                                            <a href="javascript:void(0)" onclick="document.getElementById('delete-socialite-{{$app['app']}}').submit();">取消</a>
                                            <form id="delete-socialite-{{$app['app']}}" action="{{route('member.socialite.delete', [$app['app']])}}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        @else
                                            <a target="_blank" href="{{route('socialite', [$app['app']])}}">绑定</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center color-gray" colspan="2">暂无数据</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection