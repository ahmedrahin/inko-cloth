<header class="tf-header header-fix">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 col-3 d-xl-none">
                <a href="#mobileMenu" data-bs-toggle="offcanvas" class="btn-mobile-menu">
                    <span></span>
                </a>
            </div>
            <div class="col-xl-3 col-md-4 col-6 text-center text-xl-start">
                <a href="{{ url('/') }}" class="logo-site justify-content-center justify-content-xl-start">
                    <img src="{{ config('app.logo') }}" alt="Logo">
                </a>
            </div>
            <div class="col-xl-6 d-none d-xl-block">
                <nav class="box-navigation">
                    <ul class="box-nav-menu">
                        <li class="menu-item">
                            <a href="{{ route('homepage') }}" class="item-link">HOME</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('shop') }}" class="item-link">SHOP</a>
                            <div class="sub-menu mega-menu">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="mega-menu-item">
                                                <h4 class="menu-heading">Shop Layout</h4>
                                                <ul class="sub-menu_list">
                                                    <li><a href="shop-default.html" class="sub-menu_link">Default Grid</a></li>
                                                    <li><a href="shop-default-list.html" class="sub-menu_link">Default List</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <li class="menu-item position-relative">
                            <a href="javascript:void(0)" class="item-link">BLOG</a>
                        </li>
                        <li class="menu-item position-relative">
                            <a href="{{ route('contact') }}" class="item-link">CONTACT US</a>
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
                    <li class="d-none shop-cart d-sm-flex m-0">
                        <a class="nav-icon-item link" href="{{ route('wishlist') }}"><i class="icon icon-heart"></i><livewire:frontend.wishlist.count-wishlist /></a>
                        
                    </li>
                    <li class="shop-cart" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart">
                        <a class="nav-icon-item link" href="#shoppingCart" data-bs-toggle="offcanvas">
                            <i class="icon icon-shopping-cart-simple"></i>
                             <livewire:frontend.cart.btn-cart />
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<livewire:frontend.cart.shopping-cart />
<livewire:frontend.shop.search-box />

<!-- Mobile Menu -->
<div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
    <span class="icon-close-popup" data-bs-dismiss="offcanvas">
        <i class="icon-close"></i>
    </span>
    <div class="canvas-header">
        <p class="text-logo-mb">Ochaka.</p>
        <a href="login.html" class="tf-btn type-small style-2">
            Login
            <i class="icon icon-user"></i>
        </a>
        <span class="br-line"></span>
    </div>
    <div class="canvas-body">
        <div class="mb-content-top">
            <ul class="nav-ul-mb" id="wrapper-menu-navigation"></ul>
        </div>
        <div class="group-btn">
            <a href="wishlist.html" class="tf-btn type-small style-2">
                Wishlist
                <i class="icon icon-heart"></i>
            </a>
            <div data-bs-dismiss="offcanvas">
                <a href="#search" data-bs-toggle="modal" class="tf-btn type-small style-2">
                    Search
                    <i class="icon icon-magnifying-glass"></i>
                </a>
            </div>
        </div>
        <div class="flow-us-wrap">
            <h5 class="title">Follow us on</h5>
            <ul class="tf-social-icon">
                <li>
                    <a href="https://www.facebook.com/" target="_blank" class="social-facebook">
                        <span class="icon"><i class="icon-fb"></i></span>
                    </a>
                </li>
                <li>
                    <a href="https://www.instagram.com/" target="_blank" class="social-instagram">
                        <span class="icon"><i class="icon-instagram-logo"></i></span>
                    </a>
                </li>
                <li>
                    <a href="https://x.com/" target="_blank" class="social-x">
                        <span class="icon"><i class="icon-x"></i></span>
                    </a>
                </li>
                <li>
                    <a href="https://www.tiktok.com/" target="_blank" class="social-tiktok">
                        <span class="icon"><i class="icon-tiktok"></i></span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="payment-wrap">
            <h5 class="title">Payment:</h5>
            <ul class="payment-method-list">
                <li><img src="images/payment/visa.png" alt="Payment"></li>
                <li><img src="images/payment/master-card.png" alt="Payment"></li>
                <li><img src="images/payment/amex.png" alt="Payment"></li>
                <li><img src="images/payment/discover.png" alt="Payment"></li>
                <li><img src="images/payment/paypal.png" alt="Payment"></li>
            </ul>
        </div>
    </div>
    <div class="canvas-footer">
        <div class="tf-currencies">
            <select class="tf-dropdown-select style-default type-currencies">
                <option selected data-thumbnail="images/country/us.png">USD</option>
                <option data-thumbnail="images/country/vie.png">VND</option>
            </select>
        </div>
        <span class="br-line"></span>
        <div class="tf-languages">
            <select class="tf-dropdown-select style-default type-languages">
                <option>English</option>
                <option>العربية</option>
                <option>简体中文</option>
                <option>اردو</option>
            </select>
        </div>
    </div>
</div>