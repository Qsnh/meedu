@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">我的消息</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tbody>
                            @forelse($messages as $message)
                                <tr>
                                    {!! (new \App\Meedu\NotificationParse())->parseHTML($message) !!}
                                </tr>
                                @if($message->markAsRead())@endif
                            @empty
                                <tr>暂无数据</tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-10">
                <div class="text-right">
                    {{$messages->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection