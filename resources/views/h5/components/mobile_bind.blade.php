<script>
    $(function () {
        const mobileIsBind = {{ $user && !request()->routeIs('member.mobile.bind') && config('meedu.member.enabled_mobile_bind_alert') && app()->make(\App\Businesses\BusinessState::class)->isNeedBindMobile($user) ? 1 : 0}};
        if (mobileIsBind === 1) {
            window.location = '{{route('member.mobile.bind')}}';
        }
    });
</script>