<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">

                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                {{-- <strong class="font-bold">K-tech</strong> --}}
                            </span>
                            <span class="text-muted text-xs block">
                                <img class="img-banner-siderbar"
                                    src="https://live.k-tech.net.vn/seo_system/public/core/assets/images/logo.png"
                                    alt="">
                            </span>
                        </span>
                    </a>

                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            {{-- Module Khách hàng --}}
            <li class="active">
                <a href="{{ route('user.index')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Clients</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    {{-- <li><a href="index.html">Quản lí Nhóm Thành Viên</a></li> --}}
                    <li><a href="{{ route('user.index')}}">Customer</a></li>

                </ul>
            </li>
            {{-- Module đơn hàng --}}
            <li class="active">
                <a href="{{ route('user.order')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Quản lí đơn
                        hàng</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('user.order')}}">Đơn hàng</a></li>

                </ul>
            </li>

            {{-- Module sản phẩm hàng --}}
            <li class="active">
                <a href="{{ route('product.index')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Quản lí sản
                        phẩm</span>
                    <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('product.index')}}">Sản phẩm</a></li>

                </ul>
            </li>


        </ul>

    </div>
</nav>