@extends('frontend.layout.app')

@section('page-title')
    Shop Products
@endsection

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/nouislider/nouislider.min.css') }}">
@endsection

@section('body-content')
    
    <div id="wrapper">
        <!-- Page Title -->
        <section class="s-page-title">
            <div class="container">
                <div class="content">
                    <h1 class="title-page">Shop Default Grid</h1>
                    <ul class="breadcrumbs-page">
                        <li><a href="index.html" class="h6 link">Home</a></li>
                        <li class="d-flex"><i class="icon icon-caret-right"></i></li>
                        <li>
                            <h6 class="current-page fw-normal">Shop</h6>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- <div class="flat-spacing pb-0">
            <div class="container">
                <div dir="ltr" class="swiper tf-swiper" data-preview="5" data-tablet="4" data-mobile-sm="3" data-mobile="2" data-space-lg="40"
                    data-space-md="24" data-space="12" data-pagination="2" data-pagination-sm="3" data-pagination-md="4" data-pagination-lg="5">
                    <div class="swiper-wrapper">
                        @foreach (App\Models\Category::where('featured', 1)->where('status', 1)->latest()->get() as $category)
                            <div class="swiper-slide">
                                <div class="box-image_category style-2 hover-img">
                                    <a href="" class="box-image_image img-style">
                                        <img class="lazyload" src="{{ asset($category->image ?? 'frontend/images/noimg.jpg') }}" data-src="{{ asset($category->image ?? 'frontend/images/noimg.jpg') }}" alt="">
                                    </a>
                                    <div class="box-image_content">
                                        <a href="" class="tf-btn btn-white animate-btn animate-dark">
                                            <span class="h5 fw-medium">
                                                {{ $category->name }}
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="sw-dot-default tf-sw-pagination"></div>
                </div>
            </div>
        </div> --}}

        <div class="flat-spacing-3 pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="canvas-sidebar sidebar-filter canvas-filter left">
                            <div class="canvas-wrapper">
                                <div class="canvas-header d-xl-none">
                                    <span class="title h3 fw-medium">Filter</span>
                                    <span class="icon-close link icon-close-popup fs-24 close-filter"></span>
                                </div>
                                <div class="canvas-body">
                                    <div class="widget-facet">
                                        <div class="facet-title" data-bs-target="#category" role="button" data-bs-toggle="collapse"
                                            aria-expanded="true" aria-controls="category">
                                            <span class="h4 fw-semibold">Category</span>
                                            <span class="icon icon-caret-down fs-20"></span>
                                        </div>
                                        <div id="category" class="collapse show">
                                            <ul class="collapse-body filter-group-check group-category">
                                                <li class="list-item">
                                                    <a href="shop-default.html" class="link h6">T-shirts<span class="count">23</span></a>
                                                </li>
                                                <li class="list-item">
                                                    <a href="shop-default.html" class="link h6">Footwear<span class="count">44</span></a>
                                                </li>
                                                <li class="list-item">
                                                    <a href="shop-default.html" class="link h6">Shirts<span class="count">75</span></a>
                                                </li>
                                                <li class="list-item">
                                                    <a href="shop-default.html" class="link h6">Dresses<span class="count">33</span></a>
                                                </li>
                                                <li class="list-item">
                                                    <a href="shop-default.html" class="link h6">Underwear<span class="count">45</span></a>
                                                </li>
                                                <li class="list-item">
                                                    <a href="shop-default.html" class="link h6">Accessories<span class="count">32</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="widget-facet">
                                        <div class="facet-title" data-bs-target="#price" role="button" data-bs-toggle="collapse" aria-expanded="true"
                                            aria-controls="price">
                                            <span class="h4 fw-semibold">Price</span>
                                            <span class="icon icon-caret-down fs-20"></span>
                                        </div>
                                        <div id="price" class="collapse show">
                                            <div class="collapse-body widget-price filter-price">
                                                <div class="price-val-range" id="price-value-range" data-min="0" data-max="500"></div>
                                                <div class="box-value-price">
                                                    <span class="h6 text-main">Price:</span>
                                                    <div class="price-box">
                                                        <div class="price-val" id="price-min-value" data-currency="$"></div>
                                                        <span>-</span>
                                                        <div class="price-val" id="price-max-value" data-currency="$"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-facet">
                                        <div class="facet-title" data-bs-target="#brand" role="button" data-bs-toggle="collapse" aria-expanded="true"
                                            aria-controls="brand">
                                            <span class="h4 fw-semibold">Brand</span>
                                            <span class="icon icon-caret-down fs-20"></span>
                                        </div>
                                        <div id="brand" class="collapse show">
                                            <ul class="collapse-body filter-group-check current-scrollbar">
                                                <li class="list-item">
                                                    <input type="checkbox" name="brand" class="tf-check" id="automet">
                                                    <label for="automet" class="label">AUTOMET</label>
                                                </li>
                                                <li class="list-item">
                                                    <input type="checkbox" name="brand" class="tf-check" id="trendy-queen">
                                                    <label for="trendy-queen" class="label">Trendy Queen</label>
                                                </li>
                                                <li class="list-item">
                                                    <input type="checkbox" name="brand" class="tf-check" id="wiholl">
                                                    <label for="wiholl" class="label">WIHOLL</label>
                                                </li>
                                                <li class="list-item">
                                                    <input type="checkbox" name="brand" class="tf-check" id="real-essentials">
                                                    <label for="real-essentials" class="label">Real Essentials</label>
                                                </li>
                                                <li class="list-item">
                                                    <input type="checkbox" name="brand" class="tf-check" id="dokotoo">
                                                    <label for="dokotoo" class="label">Dokotoo</label>
                                                </li>
                                                <li class="list-item">
                                                    <input type="checkbox" name="brand" class="tf-check" id="hanes">
                                                    <label for="hanes" class="label">Hanes</label>
                                                </li>
                                                <li class="list-item">
                                                    <input type="checkbox" name="brand" class="tf-check" id="zeagoo">
                                                    <label for="zeagoo" class="label">Zeagoo</label>
                                                </li>
                                                <li class="list-item">
                                                    <input type="checkbox" name="brand" class="tf-check" id="shewin">
                                                    <label for="shewin" class="label">SHEWIN</label>
                                                </li>
                                                <li class="list-item">
                                                    <input type="checkbox" name="brand" class="tf-check" id="blooming-jelly">
                                                    <label for="blooming-jelly" class="label">Blooming Jelly</label>
                                                </li>
                                                <li class="list-item">
                                                    <input type="checkbox" name="brand" class="tf-check" id="fisoew">
                                                    <label for="fisoew" class="label">Fisoew</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    {{-- <div class="widget-facet">
                                        <div class="facet-title" data-bs-target="#color" role="button" data-bs-toggle="collapse" aria-expanded="true"
                                            aria-controls="size">
                                            <span class="h4 fw-semibold">Color</span>
                                            <span class="icon icon-caret-down fs-20"></span>
                                        </div>
                                        <div id="color" class="collapse show">
                                            <div class="collapse-body filter-color-box flat-check-list">
                                                <div class="check-item color-item color-check">
                                                    <span class="color bg-light-purple"></span>
                                                    <span class="color-text">Purple</span>
                                                </div>
                                                <div class="check-item color-item color-check">
                                                    <span class="color bg-dark-charcoal"></span>
                                                    <span class="color-text">Dark</span>
                                                </div>
                                                <div class="check-item color-item color-check line">
                                                    <span class="color bg-dark-jade"></span>
                                                    <span class="color-text">Green</span>
                                                </div>
                                                <div class="check-item color-item color-check">
                                                    <span class="color bg-light-beige"></span>
                                                    <span class="color-text">Beige</span>
                                                </div>
                                                <div class="check-item color-item color-check">
                                                    <span class="color bg-sage-green"></span>
                                                    <span class="color-text">Sage Green</span>
                                                </div>
                                                <div class="check-item color-item color-check">
                                                    <span class="color bg-tomato"></span>
                                                    <span class="color-text">Light Orange</span>
                                                </div>
                                                <div class="check-item color-item color-check">
                                                    <span class="color bg-honey-orange"></span>
                                                    <span class="color-text">Orange</span>
                                                </div>
                                                <div class="check-item color-item color-check">
                                                    <span class="color bg-dark-olive"></span>
                                                    <span class="color-text">Dark Olive</span>
                                                </div>
                                                <div class="check-item color-item color-check">
                                                    <span class="color bg-hot-pink"></span>
                                                    <span class="color-text">Pink</span>
                                                </div>
                                                <div class="check-item color-item color-check">
                                                    <span class="color bg-muted-violet"></span>
                                                    <span class="color-text">Dark Violet</span>
                                                </div>
                                                <div class="check-item color-item color-check">
                                                    <span class="color bg-dusty-olive"></span>
                                                    <span class="color-text">Dusty Olive</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                   
                                </div>
                                <div class="canvas-bottom d-xl-none">
                                    <button id="reset-filter" class="tf-btn btn-reset">Reset Filters</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="tf-shop-control">
                            <div class="shop-sale-text d-none d-xl-flex">
                                <input type="checkbox" name="sale" class="tf-check" id="sale">
                                <label for="sale" class="label">Show only products on sale</label>
                            </div>
                            <div class="tf-control-filter d-xl-none">
                                <button type="button" id="filterShop" class="tf-btn-filter">
                                    <span class="icon icon-filter"></span><span class="text">Filter</span>
                                </button>
                            </div>
                            <ul class="tf-control-layout">
                                <li class="tf-view-layout-switch sw-layout-2" data-value-layout="tf-col-2">
                                    <i class="icon-grid-2"></i>
                                </li>
                                <li class="tf-view-layout-switch sw-layout-3 active d-none d-md-flex" data-value-layout="tf-col-3">
                                    <i class="icon-grid-3"></i>
                                </li>
                                <li class="br-line type-vertical"></li>
                                <li class="tf-view-layout-switch sw-layout-list list-layout" data-value-layout="list">
                                    <i class="icon-list"></i>
                                </li>
                            </ul>
                            <div class="tf-control-sorting">
                                <p class="h6 d-none d-lg-block">Sort by:</p>
                                <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                                    <div class="btn-select">
                                        <span class="text-sort-value">Best Selling</span>
                                        <span class="icon icon-caret-down"></span>
                                    </div>
                                    <div class="dropdown-menu">
                                        <div class="select-item active remove-all-filters" data-sort-value="best-selling">
                                            <span class="text-value-item">Best Selling</span>
                                        </div>
                                        <div class="select-item" data-sort-value="a-z">
                                            <span class="text-value-item">Alphabetically, A-Z</span>
                                        </div>
                                        <div class="select-item" data-sort-value="z-a">
                                            <span class="text-value-item">Alphabetically, Z-A</span>
                                        </div>
                                        <div class="select-item" data-sort-value="price-low-high">
                                            <span class="text-value-item">Price, low to high</span>
                                        </div>
                                        <div class="select-item" data-sort-value="price-high-low">
                                            <span class="text-value-item">Price, high to low</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper-control-shop gridLayout-wrapper">
                            <div class="meta-filter-shop">
                                <div id="product-count-grid" class="count-text"></div>
                                <div id="product-count-list" class="count-text"></div>
                                <div id="applied-filters"></div>
                                <button id="remove-all" class="remove-all-filters" style="display: none;">
                                    <i class="icon icon-close"></i>
                                    Clear all</button>
                            </div>
                            <div class="tf-list-layout wrapper-shop" id="listLayout" style="display: none;">
                                
                            </div>
                             @include('frontend.pages.shop.product-list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Section Product -->
        <!-- Box Icon -->
        <div class="flat-spacing">
            <div class="container">
                <div dir="ltr" class="swiper tf-swiper" data-preview="4" data-tablet="3" data-mobile-sm="2" data-mobile="1" data-space-lg="97"
                    data-space-md="33" data-space="13" data-pagination="1" data-pagination-sm="2" data-pagination-md="3" data-pagination-lg="4">
                    <div class="swiper-wrapper">
                        <!-- item 1 -->
                        <div class="swiper-slide">
                            <div class="box-icon_V01">
                                <span class="icon">
                                    <i class="icon-package"></i>
                                </span>
                                <div class="content">
                                    <h4 class="title fw-normal">30 days return</h4>
                                    <p class="text">30 day money back guarantee</p>
                                </div>
                            </div>
                        </div>
                        <!-- item 2 -->
                        <div class="swiper-slide">

                            <div class="box-icon_V01">
                                <span class="icon">
                                    <i class="icon-calender"></i>
                                </span>
                                <div class="content">
                                    <h4 class="title fw-normal">3 year warranty</h4>
                                    <p class="text">Manufacturer's defect</p>
                                </div>
                            </div>
                        </div>
                        <!-- item 3 -->
                        <div class="swiper-slide">

                            <div class="box-icon_V01">
                                <span class="icon">
                                    <i class="icon-boat"></i>
                                </span>
                                <div class="content">
                                    <h4 class="title fw-normal">Free shipping</h4>
                                    <p class="text">Free Shipping for orders over $150</p>
                                </div>
                            </div>
                        </div>
                        <!-- item 4 -->
                        <div class="swiper-slide">
                            <div class="box-icon_V01">
                                <span class="icon">
                                    <i class="icon-headset"></i>
                                </span>
                                <div class="content">
                                    <h4 class="title fw-normal">Online support</h4>
                                    <p class="text">24 hours a day, 7 days a week</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sw-dot-default tf-sw-pagination"></div>
                </div>
            </div>
        </div>

        <div class="overlay-filter" id="overlay-filter"></div>
    </div>

@endsection


@section('page-script')

    <script src="{{ asset('frontend/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('frontend/js/shop.js') }}"></script>

@endsection
