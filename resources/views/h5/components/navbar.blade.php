<div class="footer-navbar">
    <a href="{{route('index')}}" class="navbar-item {{menu_active('index')}}">
        <div class="icon">
            <img src="/h5/images/icons/index{{menu_active('index') === 'active' ? '-active' : ''}}.png" width="20" height="20">
        </div>
        <div class="title">发现</div>
    </a>
    <a href="{{route('courses')}}" class="navbar-item {{menu_active('courses')}}">
        <div class="icon">
            <img src="/h5/images/icons/all{{menu_active('courses') === 'active' ? '-active' : ''}}.png" width="20" height="20">
        </div>
        <div class="title">全部</div>
    </a>
    <a href="{{route('member')}}" class="navbar-item {{menu_active('member')}}">
        <div class="icon">
            <img src="/h5/images/icons/me{{menu_active('member') === 'active' ? '-active' : ''}}.png" width="20" height="20">
        </div>
        <div class="title">我的</div>
    </a>
</div>