@if(auth()->check())
    @if(!auth()->user()->isBindMobile())
        <div class="container mt-2 mb-2">
            <div class="col-sm">
                <div class="alert alert-info">
                    您未绑定手机号，请 <a href="{{route('member.mobile.bind')}}"><b>点击绑定</b></a>
                </div>
            </div>
        </div>
    @endif
@endif