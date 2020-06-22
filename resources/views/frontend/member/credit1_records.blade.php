@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="credit1-box">
                    <div class="left-box">
                        <div class="value">
                            <div class="icon">
                                <img src="{{asset('/images/icons/member/credit1-active.png')}}" width="30" height="30">
                            </div>
                            <div class="help">
                                可用积分
                            </div>
                            <div class="credit1">{{$user['credit1']}}</div>
                        </div>
                    </div>
                    <div class="right-box">
                        <div class="title">
                            <div class="icon">
                                <img src="{{asset('/images/icons/member/credit1-page-1.png')}}" width="46" height="66"">
                            </div>
                            <div class="text">积分规则</div>
                        </div>
                        <div class="content">
                            @if($index = 1)@endif
                            @if(($credit = \Illuminate\Support\Arr::get($gConfig, 'member.credit1.register', 0)) > 0)
                                <div class="item">
                                    {{$index++}}.注册送 {{$credit}} 积分
                                </div>
                            @endif
                            @if(($credit = \Illuminate\Support\Arr::get($gConfig, 'member.credit1.invite', 0)) > 0)
                                <div class="item">
                                    {{$index++}}.邀请送 {{$credit}} 积分
                                </div>
                            @endif
                            @if(($credit = \Illuminate\Support\Arr::get($gConfig, 'member.credit1.watched_course', 0)) > 0)
                                <div class="item">
                                    {{$index++}}.看完课程送 {{$credit}} 积分
                                </div>
                            @endif
                            @if(($credit = \Illuminate\Support\Arr::get($gConfig, 'member.credit1.watched_video', 0)) > 0)
                                <div class="item">
                                    {{$index++}}.看完视频送 {{$credit}} 积分
                                </div>
                            @endif
                            @if(($credit = \Illuminate\Support\Arr::get($gConfig, 'member.credit1.paid_order', 0)) > 0)
                                <div class="item">
                                    {{$index++}}.已支付订单赠送 订单金额x{{$credit*100}}% 积分
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="credit1-records-box">
                    @forelse($records as $record)
                    <div class="item">
                        <div class="remark">{{$record['remark']}}</div>
                        <div class="value">{{$record['sum']}}</div>
                        <div class="date">{{$record['created_at']}}</div>
                    </div>
                    @empty
                        @include('frontend.components.none')
                    @endforelse
                </div>
            </div>

            @if($records->total() > $records->perPage())
                <div class="col-12">
                    {!! str_replace('pagination', 'pagination justify-content-center', $records->render()) !!}
                </div>
            @endif
        </div>
    </div>

@endsection