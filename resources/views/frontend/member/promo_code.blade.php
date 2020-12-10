@extends('layouts.member')

@section('member')

    @if($userPromoCode)
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="promo_code_banner">
                        <div class="promo_code_balance">
                            <div class="promo_code_code">
                                <span class="title">我的邀请码</span>
                                <span class="code">{{$userPromoCode['code']}}</span>
                            </div>
                            <div class="promo_code_balance_info">
                                <span class="title">邀请奖励金</span>
                                <span class="balance"><small>￥</small>{{$user['invite_balance']}}</span>
                                <a href="javascript:void(0)" class="withdraw-button"
                                   onclick="showAuthBox('invite-withdraw')">提现</a>
                            </div>
                        </div>
                        <div class="promo_code_intro">
                            <div class="promo_code_intro_title">
                                <img src="/images/icons/member/promo_code_intro.png" width="89" height="66">
                                <span>邀请码权益</span>
                            </div>
                            <div class="promo_code_intro_content">
                                <p>1.使用该邀请码的用户将获得 {{$userPromoCode['invited_user_reward']}} 元抵扣。</p>
                                <p>2.当用户使用您的邀请码支付并完成订单的时候，您也将获得 {{$userPromoCode['invite_user_reward']}} 元奖励。</p>
                                <p>3.使用您的邀请码完成支付的用户将会自动成为您的下级，TA的每一笔已支付订单您都将享有 {{$inviteConfig['per_order_draw']*100}}%
                                    的抽成。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-12 my-5 text-center">
                    <form action="" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">生成我的专属邀请码</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="course-menu-box">
                    <div class="menu-item {{!$scene ? 'active' : ''}}">
                        <a href="{{route('member.promo_code')}}?{{$queryParams(['scene' => ''])}}">邀请记录</a>
                    </div>
                    <div class="menu-item {{$scene === 'records' ? 'active' : ''}}">
                        <a href="{{route('member.promo_code')}}?{{$queryParams(['scene' => 'records'])}}">余额明细</a>
                    </div>
                    <div class="menu-item {{$scene === 'withdraw' ? 'active' : ''}}">
                        <a href="{{route('member.promo_code')}}?{{$queryParams(['scene' => 'withdraw'])}}">提现记录</a>
                    </div>
                </div>
            </div>

            @if(!$scene)
                <div class="col-12">
                    <div class="invite-user-box">
                        @forelse($inviteUsers as $item)
                            <div class="invite-user-item">
                                <span class="invite-user-item-nickname">******{{substr($item['mobile'], 6)}}</span>
                                <span class="invite-user-item-date">{{\Carbon\Carbon::parse($item['created_at'])->format('Y-m-d H:i')}}</span>
                            </div>
                        @empty
                            @include('frontend.components.none')
                        @endforelse
                    </div>
                </div>

                @if($inviteUsers->total() > $inviteUsers->perPage())
                    <div class="col-12">
                        {!! str_replace('pagination', 'pagination justify-content-center', $inviteUsers->render()) !!}
                    </div>
                @endif

            @endif

            @if($scene === 'records')
                <div class="col-12">
                    <div class="invite-user-box">
                        @forelse($balanceRecords as $item)
                            <div class="invite-user-item">
                                <span class="invite-user-item-nickname">{{$item['desc']}}</span>
                                <span class="invite-user-item-date">{{\Carbon\Carbon::parse($item['created_at'])->format('Y-m-d H:i')}}</span>
                                <span class="invite-user-item-date">￥{{$item['total']}}</span>
                            </div>
                        @empty
                            @include('frontend.components.none')
                        @endforelse
                    </div>
                </div>

                @if($balanceRecords->total() > $balanceRecords->perPage())
                    <div class="col-12">
                        {!! str_replace('pagination', 'pagination justify-content-center', $balanceRecords->render()) !!}
                    </div>
                @endif
            @endif

            @if($scene === 'withdraw')
                <div class="col-12">
                    <div class="invite-user-box">
                        @forelse($withdrawOrders as $item)
                            <div class="invite-user-item">
                                <span class="invite-user-item-nickname">{{\Carbon\Carbon::parse($item['created_at'])->format('Y-m-d H:i')}}</span>
                                <span class="invite-user-item-date">{{$item['status_text']}}</span>
                                <span class="invite-user-item-date">￥{{$item['total']}}</span>
                            </div>
                        @empty
                            @include('frontend.components.none')
                        @endforelse
                    </div>
                </div>

                @if($withdrawOrders->total() > $withdrawOrders->perPage())
                    <div class="col-12">
                        {!! str_replace('pagination', 'pagination justify-content-center', $withdrawOrders->render()) !!}
                    </div>
                @endif
            @endif
        </div>
    </div>

    <script id="invite-withdraw" type="text/html">
        <form class="login-box" action="{{route('ajax.invite_balance.withdraw')}}" method="post">
            <div class="login-box-title" style="margin-bottom: 30px;">
                <span class="title">邀请奖励提现</span>
                <img src="/images/close.png" width="24" height="24" class="close-auth-box">
            </div>
            <div class="form-group">
                <input type="number" placeholder="提现金额" min="1" max="{{$user['invite_balance']}}" name="total"
                       class="form-control" required>
            </div>
            <div class="form-group">
                <select name="channel[name]" class="form-control">
                    <option value="支付宝">支付宝</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="channel[username]" class="form-control" placeholder="姓名">
            </div>
            <div class="form-group">
                <input type="text" name="channel[account]" class="form-control" placeholder="支付宝账户">
            </div>
            <div class="form-group auth-box-errors"></div>
            <div class="form-group mb-0">
                <button type="button" class="btn btn-primary btn-block invite-balance-withdraw-button">确认提现</button>
            </div>
        </form>
    </script>

@endsection