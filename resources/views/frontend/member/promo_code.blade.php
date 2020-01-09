@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">我的优惠码</div>
                    <div class="card-body">
                        @if($userPromoCode)
                            @if($inviteConfig['invite_balance_can_pay'])
                                <div class="alert alert-info">
                                    <i class="fa fa-info"></i> 账户邀请余额可以用来支付订单哦。
                                </div>
                            @endif
                            <p>账户邀请余额：<span class="badge badge-primary">{{$user['invite_balance']}}元</span> <a
                                        href="{{route('member.invite_balance_records')}}" class="ml-2">记录</a></p>
                            <p class="text-center">
                                <span style="font-size: 2rem; line-height: 3rem;"
                                      title="邀请码">{{$userPromoCode['code']}}</span>
                            </p>
                                <p>使用该优惠码的用户将获得 <span
                                            class="badge badge-primary">{{$userPromoCode['invited_user_reward']}}</span>
                                    元抵扣。
                                </p>
                            <p>当用户使用您的优惠码支付并完成订单的时候，您也将获得 <span
                                        class="badge badge-primary">{{$userPromoCode['invite_user_reward']}}</span> 元奖励。
                            </p>
                            <p>使用您的优惠码完成支付的用户将会自动成为您的下级，TA的每一笔已支付订单您都将享有 <span class="badge badge-primary">{{$inviteConfig['per_order_draw']*100}}%</span>
                                的抽成。</p>
                        @else
                            <form action="" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary">生成我的专属优惠码</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mt-2">
                <div class="card">
                    <div class="card-header">邀请记录</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">用户</th>
                                <th class="text-center">时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($inviteUsers as $item)
                                <tr class="text-center">
                                    <td>******{{substr($item['mobile'], 6)}}</td>
                                    <td>{{$item['created_at']}}</td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="2">暂无记录</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        {{$inviteUsers->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection