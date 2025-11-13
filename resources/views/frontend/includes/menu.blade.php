<header class="tf-header header-fix">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 col-3 d-xl-none">
                <a href="#mobileMenu" data-bs-toggle="offcanvas" class="btn-mobile-menu">
                    <span></span>
                </a>
            </div>
            <div class="col-xl-3 col-md-4 col-6 text-center text-xl-start">
                <a href="index.html" class="logo-site justify-content-center justify-content-xl-start">
                    <img src="images/logo/logo.svg" alt="Logo">
                </a>
            </div>
            <div class="col-xl-6 d-none d-xl-block">
                <nav class="box-navigation">
                    <ul class="box-nav-menu">
                        <li class="menu-item">
                            <a href="javascript:void(0)" class="item-link">HOME</a>
                        </li>
                        <li class="menu-item">
                            <a href="javascript:void(0)" class="item-link">SHOP</a>
                        </li>
                        <li class="menu-item">
                            <a href="javascript:void(0)" class="item-link">PRODUCT</a>
                        </li>
                        <li class="menu-item position-relative">
                            <a href="javascript:void(0)" class="item-link">PAGE</a>
                        </li>
                        <li class="menu-item position-relative">
                            <a href="javascript:void(0)" class="item-link">BLOG</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-xl-3 col-md-4 col-3">
                <ul class="nav-icon-list">
                    <li class="d-none d-lg-flex">
                        @if(!auth()->check())
                            <a class="nav-icon-item link" href="{{ route('user.login') }}"><i class="icon icon-user"></i></a>
                        @else
                            <a class="nav-icon-item link" href="{{ route('user.dashboard') }}"><i class="icon icon-user"></i></a>    
                        @endif
                    </li>
                    <li class="d-none d-md-flex">
                        <a class="nav-icon-item link" href="#search" data-bs-toggle="modal">
                            <i class="icon icon-magnifying-glass"></i>
                        </a>
                    </li>
                    <li class="d-none d-sm-flex">
                        <a class="nav-icon-item link" href="wishlist.html"><i class="icon icon-heart"></i></a>
                    </li>
                    <li class="shop-cart" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart">
                        <a class="nav-icon-item link" href="#shoppingCart" data-bs-toggle="offcanvas">
                            <i class="icon icon-shopping-cart-simple"></i>
                        </a>
                        <span class="count">24</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>