<div class="clear-block"></div>
<div class="tabbar-box">
    <a href="{{url('/')}}" class="tabbar-item {{$active === 'index' ? 'active' : ''}}">
        <div class="icon">
            <i class="iconfont iconhomepage"></i>
        </div>
        <div class="name">首页</div>
    </a>
    <a href="{{route('courses')}}" class="tabbar-item {{$active === 'courses' ? 'active' : ''}}">
        <div class="icon">
            <i class="iconfont iconlesson"></i>
        </div>
        <div class="name">课程</div>
    </a>
    <a href="{{route('member')}}" class="tabbar-item {{$active === 'user' ? 'active' : ''}}">
        <div class="icon">
            <i class="iconfont iconme"></i>
        </div>
        <div class="name">我的</div>
    </a>
</div>