@extends('layouts.backend_base')

@section('base')

    <!-- Preloader -->
    <div class="preloader">
        <div class="spinner-dots">
            <span class="dot1"></span>
            <span class="dot2"></span>
            <span class="dot3"></span>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar sidebar-icons-right sidebar-icons-boxed sidebar-expand-lg">
        <header class="sidebar-header">
            <span class="logo">
                <a href="{{route('backend.dashboard.index')}}" style="font-size: 2rem;">MeEdu</a>
            </span>
        </header>

        <nav class="sidebar-navigation">
            <ul class="menu">
                @foreach(backend_menus() as $menu)
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="title">{{$menu->name}}</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="menu-submenu">
                            @foreach($menu->children as $child)
                                <li class="menu-item">
                                    <a class="menu-link" href="{{$child->url}}">
                                        <span class="dot"></span>
                                        <span class="title">{{$child->name}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </nav>
    </aside>
    <!-- END Sidebar -->


    <!-- Topbar -->
    <header class="topbar">
        <div class="topbar-left">
            <span class="topbar-btn sidebar-toggler"><i>&#9776;</i></span>
        </div>

        <div class="topbar-right">
            <ul class="topbar-btns">
                <li class="dropdown">
                    <span class="topbar-btn" data-toggle="dropdown">{{ Auth::guard('administrator')->user()->name }}</span>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('backend.edit.password') }}"><i class="ti-settings"></i> 修改密码</a>
                        <a class="dropdown-item" href="{{ route('backend.logout') }}"><i class="ti-power-off"></i> 安全退出</a>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <!-- END Topbar -->

    <!-- Main container -->
    <main>
        <header class="header bg-ui-general">
            <div class="header-info">
                <h1 class="header-title">
                    <strong>@yield('title')</strong>
                </h1>
            </div>
        </header><!--/.header -->

        <div class="main-content">
            @yield('body')
        </div><!--/.main-content -->

        <!-- Footer -->
        <footer class="site-footer">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-center text-md-left">Copyright © 2019 <a href="https://meedu.vip">MeEdu</a>. All rights reserved.</p>
                </div>

                <div class="col-md-6">
                    <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
                        <li class="nav-item">
                            <a class="nav-link" href="https://meedu.vip">插件</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://github.com/Qsnh/meedu">源码</a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
        <!-- END Footer -->

    </main>
    <!-- END Main container -->

@endsection