@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12 mt-4">
                <form class="row" action="" method="post">
                    @csrf
                    <div class="col-md-3 col-12">
                        <label>提现金额</label>
                        <input type="number" max="{{$user['invite_balance']}}" min="1" name="total" class="form-control" placeholder="提现金额">
                    </div>
                    <div class="col-md-3 col-12">
                        <label>渠道</label>
                        <select name="channel[name]" class="form-control">
                            <option value="支付宝">支付宝</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-12">
                        <label>姓名</label>
                        <input type="text" name="channel[username]" class="form-control" placeholder="姓名">
                    </div>
                    <div class="col-md-3 col-12">
                        <label>支付宝账户</label>
                        <input type="text" name="channel[account]" class="form-control" placeholder="支付宝账户">
                    </div>
                    <div class="col-12 text-right mt-2">
                        <span class="mr-3 badge badge-primary">￥{{$user['invite_balance']}}</span>
                        <button class="btn btn-primary">确认提现</button>
                    </div>
                </form>
            </div>
            <div class="col-12 py-4">
                邀请余额提现明细，共{{$orders->total()}}条记录
            </div>
            <div class="col-12">
                <div class="w-100 float-left bg-fff px-3 pt-5 br-8 mb-4">
                    <table class="table">
                        <thead class="text-center">
                        <tr>
                            <th>提现金额</th>
                            <th>状态</th>
                            <th>渠道</th>
                            <th>账户</th>
                            <th>备注</th>
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                            <tr class="text-center">
                                <td>￥{{$order['total']}}</td>
                                <td>{{$order['status_text']}}</td>
                                <td>{{$order['channel']}}</td>
                                <td>{{$order['channel_name']}} / {{$order['channel_account']}}</td>
                                <td>{{$order['remark']}}</td>
                                <td>{{$order['created_at']}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center color-gray" colspan="5">暂无数据</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($orders->total() > $orders->perPage())
                <div class="col-md-12">
                    <div class="w-100 float-left bg-fff mb-4 br-8 px-3 py-4">
                        {{$orders->render()}}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection