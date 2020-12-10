@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '我的邀请', 'back' => route('member')])

    <div class="member-promoCode-page">
        <div class="nav-menus">
            <a href="{{route('member.promo_code')}}"
               class="menu-item {{request()->input('action') ? '' : 'active'}}"><span>邀请码</span></a>
            <a href="{{route('member.promo_code')}}?action=records"
               class="menu-item {{request()->input('action') === 'records' ? 'active' : ''}}"><span>邀请记录</span></a>
            <a href="{{route('member.promo_code')}}?action=balance&scene=records"
               class="menu-item {{request()->input('action') === 'balance' ? 'active' : ''}}"><span>邀请余额</span></a>
        </div>
        @if(!request()->input('action'))
            @if($userPromoCode)
                <div class="promoCode-box">
                    <div class="name">我的邀请码</div>
                    <div class="value">
                        <span>{{$userPromoCode['code']}}</span>
                    </div>
                </div>
                <div class="promoCode-desc-box">
                    <p>1.使用该邀请码的用户将获得 <b>{{$userPromoCode['invited_user_reward']}}</b> 元抵扣。</p>
                    <p>2.当用户使用您的邀请码支付并完成订单的时候，您也将获得 <b>{{$userPromoCode['invite_user_reward']}}</b> 元奖励。</p>
                    <p>3.使用您的邀请码完成支付的用户将会自动成为您的下级，TA的每一笔已支付订单您都将享有 <b>{{$inviteConfig['per_order_draw']*100}}%</b>
                        的抽成。</p>
                </div>
            @else
                <div class="create-promo-code-button-box">
                    <form action="" method="post">
                        @csrf
                        <button type="submit" class="create-promo-code-button">生成我的专属邀请码</button>
                    </form>
                </div>
            @endif

        @elseif(request()->input('action') === 'records')
            @forelse($inviteUsers as $item)
                <div class="invite-user-item">
                    <div class="invite-user-item-nickname">******{{substr($item['mobile'], 6)}}</div>
                    <div class="invite-user-item-date">{{$item['created_at']}}</div>
                </div>
            @empty
                @include('h5.components.none')
            @endforelse

            @if($inviteUsers->total() > $inviteUsers->perPage())
                <div class="box">
                    {!! str_replace('pagination', 'pagination justify-content-center', $inviteUsers->render('pagination::simple-bootstrap-4')) !!}
                </div>
            @endif
        @elseif(request()->input('action') === 'balance')
            <div class="balance-box">
                <div class="text">
                    <div class="value">
                        <small>￥</small>{{$user['invite_balance']}}
                    </div>
                    <div class="options">
                        <a href="javascript:void(0)" class="invite-balance-withdraw-box-toggle">提现</a>
                    </div>
                </div>
            </div>
            <div class="balance-records-box">
                <div class="title">余额明细</div>
                @forelse($balanceRecords as $item)
                    <div class="record-item">
                        <div class="content">
                            <div class="total">
                                @if($item['total'] > 0)
                                    <small>￥</small>{{$item['total']}}
                                @else
                                    -<small>￥</small>{{$item['total']*-1}}
                                @endif
                            </div>
                            <div class="date">{{$item['created_at']}}</div>
                        </div>
                        <div class="desc">{{$item['desc']}}</div>
                    </div>
                @empty
                    @include('h5.components.none')
                @endforelse

                @if($balanceRecords->total() > $balanceRecords->perPage())
                    <div class="box">
                        {!! str_replace('pagination', 'pagination justify-content-center', $balanceRecords->render('pagination::simple-bootstrap-4')) !!}
                    </div>
                @endif
            </div>

            <div class="balance-withdraw-submit-box-shadow">
                <div class="balance-withdraw-submit-box">
                    <div class="title">余额提现</div>
                    <form method="post">
                        <div class="form-group">
                            <input type="number" placeholder="提现金额" min="1" max="{{$user['invite_balance']}}"
                                   name="total"
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
                            <button type="button" class="btn btn-primary btn-block invite-balance-withdraw-button"
                                    data-action="{{route('ajax.invite_balance.withdraw')}}">
                                确认提现
                            </button>
                        </div>
                        <div class="form-group mb-0 text-center">
                            <a href="javascript:void(0)" class="cancel-button invite-balance-withdraw-box-toggle">取消</a>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

@endsection