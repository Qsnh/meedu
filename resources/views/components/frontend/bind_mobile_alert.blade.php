@auth
    @if(app()->make(\App\Businesses\BusinessState::class)->isNeedBindMobile($user))
        <div class="container mt-2 mb-2">
            <div class="col-sm">
                <div class="alert alert-info">
                    {!! __('text_trans_need_bind_mobile', ['link' => route('member.mobile.bind')]) !!}
                </div>
            </div>
        </div>
    @endif
@endauth