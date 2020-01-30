@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="w-100 float-left py-4 mt-4 br-8 px-3 bg-fff">
                    <span>当前会员：<b class="fs-24px">{{$user['role'] ? $user['role']['name'] : '免费会员'}}</b></span>
                    <span class="ml-4">到期时间：<b class="fs-24px">{{$user['role'] ? $user['role_expired_at'] : '-'}}</b></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4 py-5">
        <div class="row justify-content-center">
            @foreach($gRoles as $index => $roleItem)
                @if($index == 4)
                    @break
                @endif
                <div class="col-md-3 col-12 text-center role-item mb-3">
                    <a href="{{route('member.role.buy', [$roleItem['id']])}}">
                        <div class="role-item-box px-3 py-5 {{$index == 1 ? 'bg-primary' : 'bg-fff'}} br-8 box-shadow1 t1">
                            <p class="pb-3 name {{$index == 1 ? 'c-fff' : ''}}">{{$roleItem['name']}}</p>
                            <p class="price {{$index == 1 ? 'c-fff' : ''}}"><b>￥{{$roleItem['charge']}}</b>
                            </p>
                            @foreach($roleItem['desc_rows'] as $item)
                                <p class="p-0 desc-item {{$index == 1 ? 'c-fff' : ''}}">{{$item}}</p>
                            @endforeach
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 py-4">
                共{{$records->total()}}条记录
            </div>
            <div class="col-md-12 mb-4">
                <div class="w-100 float-left bg-fff px-3 pt-5 br-8">
                    <table class="table">
                        <thead class="text-center">
                        <tr>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>价格</th>
                            <th>会员</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($records as $record)
                            <tr class="text-center">
                                <td>{{$record['started_at']}}</td>
                                <td>{{$record['expired_at']}}</td>
                                <td><span class="label label-default">￥{{$record['charge']}}</span></td>
                                <td>{{$record['role']['name']}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center color-gray" colspan="4">暂无数据</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($records->total() > $records->perPage())
                <div class="col-md-12">
                    <div class="w-100 float-left bg-fff mb-4 br-8 px-3 py-4">
                        {{$records->render()}}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection