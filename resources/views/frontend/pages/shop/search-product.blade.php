@extends('frontend.layout.app')

@section('page-title')
   Search - {{ $searchTerm }}
@endsection

@section('page-css')

@endsection

@section('body-content')

     <div id="wrapper">
        <!-- Page Title -->
        <section class="s-page-title">
            <div class="container">
                <div class="content">
                    <h1 class="title-page">Search Products</h1>
                    <ul class="breadcrumbs-page">
                        <li><a href="{{ route('homepage') }}" class="h6 link">Home</a></li>
                        <li class="d-flex"><i class="icon icon-caret-right"></i></li>
                        <li>
                            <h6 class="current-page fw-normal">Search - {{ $searchTerm }}</h6>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <div class="flat-spacing-3" style="margin-bottom: 70px;">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3">
                        @include('frontend.pages.shop.filter')
                    </div>
                    
                    <div class="col-xl-9">
                        <div class="tf-shop-control">
                            @include('frontend.pages.shop.filter-tags')
                            <div class="tf-control-sorting">
                                <p class="h6 d-none d-lg-block">Sort by:</p>
                                <div class="custom-select">
                                    <select id="input-sort">
                                        <option value="" {{ request('sort')=='' ? 'selected' : '' }}>Sorting..</option>
                                        <option value="best_selling" {{ request('sort')=='best_selling' ? 'selected' : '' }}>Best Selling</option>
                                        <option value="offer_price" {{ request('sort')=='offer_price' ? 'selected' : '' }}>Price, low to high
                                        </option>
                                        <option value="offer_price_desc" {{ request('sort')=='offer_price_desc' ? 'selected' : '' }}>Price, high to
                                            low</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="wrapper-control-shop gridLayout-wrapper">

                            <div class="wrapper-shop tf-grid-layout tf-col-3" id="gridLayout">
                                @include('frontend.pages.shop.product-list')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overlay-filter" id="overlay-filter"></div>
    </div>



@endsection


@section('page-script')

    

@endsection
